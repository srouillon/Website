<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
	public function __construct(
		private                           $targetDirectory,
		private readonly SluggerInterface $slugger,
	)
	{
	}

	public function upload(UploadedFile $file): string
	{
		$originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$safeFilename = $this->slugger->slug($originalFilename);
		$fileName = md5($safeFilename . uniqid()) . '.' . $file->guessExtension();

		try {
			$file->move($this->getTargetDirectory(), $fileName);
		} catch (FileException $e) {
			dd($e);
		}

		return $fileName;
	}

	public function getTargetDirectory(): string
	{
		return $this->targetDirectory;
	}
}