<?php

namespace ahmadasjad\yii2PlusYii1;

use yii\log\Logger as BaseLogger;
use CLogger;

trait Yii1Compatibility
{
    public static $enableIncludePath = true;

    /** @var \yii\log\Logger */
    private static $_logger;

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(['YiiBase', $name], $arguments);
    }

    public static function getLogger()
    {
        if (self::$_logger === null) {
            self::$_logger = static::createObject(Logger::class);
            parent::setLogger(self::$_logger);
        }
        return parent::getLogger();
    }

    public static function log($msg, $level = CLogger::LEVEL_INFO, $category = 'application')
    {
        switch ($level) {
            case CLogger::LEVEL_TRACE:
                $level = BaseLogger::LEVEL_TRACE;
                break;
            case CLogger::LEVEL_WARNING:
                $level = BaseLogger::LEVEL_WARNING;
                break;
            case CLogger::LEVEL_INFO:
                $level = BaseLogger::LEVEL_INFO;
                break;
            case CLogger::LEVEL_PROFILE:
                $level = BaseLogger::LEVEL_PROFILE;
                break;
            default:
                $level = BaseLogger::LEVEL_ERROR;
        }

        static::getLogger()->log($msg, $level, $category);
    }

    /**
     * Translates a message to the specified language.
     * This method supports choice format (see {@link CChoiceFormat}),
     * i.e., the message returned will be chosen from a few candidates according to the given
     * number value. This feature is mainly used to solve plural format issue in case
     * a message has different plural forms in some languages.
     * @param string $category message category. Please use only word letters. Note, category 'yii' is
     * reserved for Yii framework core code use. See {@link CPhpMessageSource} for
     * more interpretation about message category.
     * @param string $message the original message
     * @param array $params parameters to be applied to the message using <code>strtr</code>.
     * The first parameter can be a number without key.
     * And in this case, the method will call {@link CChoiceFormat::format} to choose
     * an appropriate message translation.
     * Starting from version 1.1.6 you can pass parameter for {@link CChoiceFormat::format}
     * or plural forms format without wrapping it with array.
     * This parameter is then available as <code>{n}</code> in the message translation string.
     * @param string $source which message source application component to use.
     * Defaults to null, meaning using 'coreMessages' for messages belonging to
     * the 'yii' category and using 'messages' for the rest messages.
     * @param string $language the target language. If null (default), the {@link CApplication::getLanguage application language} will be used.
     * @return string the translated message
     * @see CMessageSource
     */
    public static function t($category,$message,$params=array(),$source=null,$language=null)
    {
        //For Yii2 compatibility
        if(is_array($params) && !empty($params)){
            $first_param_key = array_keys($params)[0];
            if(is_string($first_param_key) && substr($first_param_key, 0, 1) != '{'){
                return parent::t($category, $message, $params, $language);
            }
        }

        //For Yii1 compatibility
        return call_user_func_array(['YiiBase', 't'], ['category' => $category, 'message' => $message, 'params' => $params, 'source' => $source, 'language' => $language]);
    }

}
