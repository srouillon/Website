<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleListener implements EventSubscriberInterface
{
	public static function getSubscribedEvents(): array
	{
		return [
			KernelEvents::REQUEST => [['onKernelRequest', 20]],
		];
	}

	public function onKernelRequest(RequestEvent $event): void
	{
		$request = $event->getRequest();

		// Définir la locale en fonction des préférences du navigateur
		$request->setLocale($request->getPreferredLanguage(['en', 'fr']));
	}
}