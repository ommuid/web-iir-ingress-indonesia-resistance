<?php
class MessageHelper
{
    public static function missingTranslation($event)
    {
        $body = implode("\n", array(
			    "Language: {$event->language}",
			    "Category: {$event->category}",
			    "Message: {$event->message}",
        ));
		print_r($event);
		echo $body;
    }
}
?>