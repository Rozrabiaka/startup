<?php

class UploadImage
{
	protected $file;
	protected $referer = false;
	protected $domains = array('localhost', 'freehome.com.ua');

	public function __construct()
	{
		$this->file = $_FILES;
		foreach ($this->domains as $domain) {
			if (strpos($_SERVER['HTTP_REFERER'], $domain) === false) {
				continue;
			} else {
				$this->referer = true;
				break;
			}
		}
	}

	public function uploadImage()
	{
		if ($this->file['upload'] AND $this->referer) {

			$allowedImageExtension = array(
				'png',
				'jpg',
				'jpeg'
			);

			$extension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

			if ($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 1000000) {
				return $this->showResult(false, '', 'The image should not exceed 1MB.');
			} else if (!in_array($extension, $allowedImageExtension)) {
				return $this->showResult(false, '', 'Upload valiid images. Only PNG and JPEG are allowed.');
			} else if (!is_uploaded_file($_FILES['upload']["tmp_name"])) {
				return $this->showResult(false, '', 'Upload Error, Please try again.');
			} else {
				//Rename the image here the way you want
				$name = uniqid(rand(), true) . '.' . $extension;
				$folder = $_SERVER['DOCUMENT_ROOT'] . '/frontend/web/uploads/removeImages/';
				if (!file_exists($folder)) {
					mkdir($folder, 0777, true);
				}
				$url = $this->siteURL() . 'uploads/removeImages/' . $name;

				//TODO Optimization image

				$success = move_uploaded_file($_FILES['upload']['tmp_name'], $folder . $name);
				if (!$success)
					return $this->showResult(false, '', 'Error uploaded.');

				return $this->showResult(true, $url);
			}
		}

		return $this->showResult(false, '', 'Unknown error.');
	}

	protected function showResult($uploaded, $url = '', $error = '')
	{
		$result['uploaded'] = $uploaded;
		if (!empty($url)) $result['url'] = $url;
		if (!empty($error)) $result['error'] = array('message' => $error);
		return $result;
	}

	protected function siteURL()
	{
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = $_SERVER['HTTP_HOST'] . '/';
		return $protocol . $domainName;
	}
}

$uploadImage = new UploadImage();
echo json_encode($uploadImage->uploadImage());