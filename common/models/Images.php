<?php

namespace common\models;

use claviska\SimpleImage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class Images extends Model
{
	/**
	 * Communities page.
	 *
	 * @param array $image
	 * @param bool $remove
	 * @param string $imgRemovePath
	 * @param string $model
	 * @return mixed
	 */
	public static function uploadAvatar($image, $imgRemovePath = '', $model = '', $remove = true)
	{
		$uploadPath = Yii::getAlias('@uploads') . '/avatars/' . date('Y') . '/' . date('m');
		$path = Yii::getAlias('@frontend') . '/web' . $uploadPath;
		if (!is_dir($path))
			mkdir($path, 0777, true);

		foreach ($image as $file) {
			$fileName = md5(microtime() . rand(0, 9999)) . '_' . $file->name;
			$imagePath = $path . '/' . $fileName;

			self::optimizateImage($file->tempName, $imagePath);
			if ($remove) self::removeAvatar($imgRemovePath, $model);

			return $uploadPath . '/' . $fileName;
		}

		return false;
	}

	public static function removeAvatar($path, $model)
	{
		$modelPath = explode('\\', $model);
		$modelClassName = array_pop($modelPath);

		switch ($modelClassName) {
			case 'User':
				if (file_exists(Yii::getAlias('@frontend') . '/web' . $path)
					and !empty($path)
					and $path !== Yii::getAlias('@imgDefault')
				) {
					unlink(Yii::getAlias('@frontend') . '/web' . $path);
				}
				break;
			default:
				if (file_exists(Yii::getAlias('@frontend') . '/web' . $path)) {
					unlink(Yii::getAlias('@frontend') . '/web' . $path);
				}
				break;
		}
	}

	public static function optimizateImage($tempName, $imageSavePath, $resizeWidth = 200)
	{
		list($width) = getimagesize($tempName);

		if ($width > 200) {
			$image = new SimpleImage();
			// Magic! ✨
			$image
				->fromFile($tempName)
				->autoOrient()
				->resize($resizeWidth)
				->toFile($tempName);
		}

		$optimizerChain = OptimizerChainFactory::create();
		$optimizerChain
			->addOptimizer(new Pngquant([
				9,
				'--force',
				'--skip-if-larger',
			]))
			->optimize($tempName, $imageSavePath);

		return true;
	}

	public static function transferImage($fromImage)
	{
		$dateFolder = date('Y') . '/' . date('m');
		$filePath = Yii::getAlias('@frontend') . '/web/uploads/removeImages/' . $fromImage;
		$destinationFilePath = Yii::getAlias('@frontend') . '/web/uploads/historyFiles/' . $dateFolder;

		if (!file_exists($destinationFilePath))
			mkdir($destinationFilePath, 0755, true);

		if (file_exists($filePath)) {
			shell_exec("cp -r $filePath $destinationFilePath");
			unlink($filePath);
		}

		return array(
			'newFilePath' => Yii::$app->request->hostInfo . '/uploads/historyFiles/' . $dateFolder . '/' . $fromImage,
			'oldFilePath' => Yii::$app->request->hostInfo . '/uploads/removeImages/' . $fromImage
		);
	}
}
