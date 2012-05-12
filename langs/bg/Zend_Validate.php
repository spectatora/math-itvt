<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Translate
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Zend_Validate.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * EN-Revision: 21134
 */
return array(
    // Zend_Validate_Alnum
    "Invalid type given, value should be float, string, or integer" => "Грешка! Стойността трябва да е float, string или integer",
    "'%value%' contains characters which are non alphabetic and no digits" => "Позволени са само букви и цифри",
    "'%value%' is an empty string" => "Полето не бива да е празно",

    // Zend_Validate_Alpha
    "Invalid type given, value should be a string" => "Грешка! Стойността трябва да е низ",
    "'%value%' contains non alphabetic characters" => "Позволени са само букви",
    "'%value%' is an empty string" => "Полето не бива да е празно",

    // Zend_Validate_Barcode
    "'%value%' failed checksum validation" => "'%value%' failed checksum validation",
    "'%value%' contains invalid characters" => "'%value%' contains invalid characters",
    "'%value%' should have a length of %length% characters" => "'%value%' should have a length of %length% characters",
    "Invalid type given, value should be string" => "Invalid type given, value should be string",

    // Zend_Validate_Between
    "'%value%' is not between '%min%' and '%max%', inclusively" => "'%value%' is not between '%min%' and '%max%', inclusively",
    "'%value%' is not strictly between '%min%' and '%max%'" => "'%value%' is not strictly between '%min%' and '%max%'",

    // Zend_Validate_Callback
    "'%value%' is not valid" => "'%value%' is not valid",
    "Failure within the callback, exception returned" => "Failure within the callback, exception returned",

    // Zend_Validate_Ccnum
    "'%value%' must contain between 13 and 19 digits" => "'%value%' must contain between 13 and 19 digits",
    "Luhn algorithm (mod-10 checksum) failed on '%value%'" => "Luhn algorithm (mod-10 checksum) failed on '%value%'",

    // Zend_Validate_CreditCard
    "Luhn algorithm (mod-10 checksum) failed on '%value%'" => "Luhn algorithm (mod-10 checksum) failed on '%value%'",
    "'%value%' must contain only digits" => "'%value%' must contain only digits",
    "Invalid type given, value should be a string" => "Invalid type given, value should be a string",
    "'%value%' contains an invalid amount of digits" => "'%value%' contains an invalid amount of digits",
    "'%value%' is not from an allowed institute" => "'%value%' is not from an allowed institute",
    "Validation of '%value%' has been failed by the service" => "Validation of '%value%' has been failed by the service",
    "The service returned a failure while validating '%value%'" => "The service returned a failure while validating '%value%'",

    // Zend_Validate_Date
    "Invalid type given, value should be string, integer, array or Zend_Date" => "Invalid type given, value should be string, integer, array or Zend_Date",
    "'%value%' does not appear to be a valid date" => "Датата не е валидна",
    "'%value%' does not fit the date format '%format%'" => "Датата не е в правилния формат '%format%'",

    // Zend_Validate_Db_Abstract
    "No record matching %value% was found" => "Не беше намеренено съвпадение",
    "A record matching %value% was found" => "Беше намерено съвдпадение",

    // Zend_Validate_Digits
    "Invalid type given, value should be string, integer or float" => "Грешка! Стойността трябва да е float, string или integer",
    "'%value%' contains characters which are not digits; but only digits are allowed" => "Позволени са само цифри",
    "'%value%' is an empty string" => "Полето не бива да е празно",

    // Zend_Validate_EmailAddress
    "Invalid type given, value should be a string" => "Грешка! Стойността трябва да е низ",
    "'%value%' is no valid email address in the basic format local-part@hostname" => "Грешна електронна поща",
    "'%hostname%' is no valid hostname for email address '%value%'" => "Грешна електронна поща!",
    "'%hostname%' does not appear to have a valid MX record for the email address '%value%'" => "Грешна електронна поща",
    "'%hostname%' is not in a routable network segment. The email address '%value%' should not be resolved from public network." => "Грешна електронна поща",
    "'%localPart%' can not be matched against dot-atom format" => "Грешна електронна поща",
    "'%localPart%' can not be matched against quoted-string format" => "Грешна електронна поща",
    "'%localPart%' is no valid local part for email address '%value%'" => "Грешна електронна поща",
    "'%value%' exceeds the allowed length" => "Елкронната поща е прекалено дълга",

    // Zend_Validate_File_Count
    "Too many files, maximum '%max%' are allowed but '%count%' are given" => "Прекалено много файлове, позволени са до %max%, а са изпратени %count%",
    "Too few files, minimum '%min%' are expected but '%count%' are given" => "Прекалено малко файлове, мининумът е %min%, а са изпратени %count%",

    // Zend_Validate_File_Crc32
    "File '%value%' does not match the given crc32 hashes" => "File '%value%' does not match the given crc32 hashes",
    "A crc32 hash could not be evaluated for the given file" => "A crc32 hash could not be evaluated for the given file",
    "File '%value%' could not be found" => "File '%value%' could not be found",

    // Zend_Validate_File_ExcludeExtension
    "File '%value%' has a false extension" => "Файлът '%value%' има грешно разшерение",
    "File '%value%' could not be found" => "Файлът '%value%' не е е открит",

    // Zend_Validate_File_ExcludeMimeType
    "File '%value%' has a false mimetype of '%type%'" => "File '%value%' has a false mimetype of '%type%'",
    "The mimetype of file '%value%' could not be detected" => "Не може да бъде засечен mimetype на файлът '%value%'",
    "File '%value%' can not be read" => "Файлът '%value%' не може да бъде отворен",

    // Zend_Validate_File_Exists
    "File '%value%' does not exist" => "Файлът '%value%' не съществува",

    // Zend_Validate_File_Extension
    "File '%value%' has a false extension" => "Файлът '%value%' има грешно разшерение",
    "File '%value%' could not be found" => "Файлът '%value%' не е е открит",

    // Zend_Validate_File_FilesSize
    "All files in sum should have a maximum size of '%max%' but '%size%' were detected" => "Сумата на всички файлове трябва да е максимум '%max%', а е зесечена '%size%'",
    "All files in sum should have a minimum size of '%min%' but '%size%' were detected" => "Сумата на всички файлове трябва да е минимум '%min%', а е засечена '%size%'",
    "One or more files can not be read" => "One or more files can not be read",

    // Zend_Validate_File_Hash
    "File '%value%' does not match the given hashes" => "File '%value%' does not match the given hashes",
    "A hash could not be evaluated for the given file" => "A hash could not be evaluated for the given file",
    "File '%value%' could not be found" => "File '%value%' could not be found",

    // Zend_Validate_File_ImageSize
    "Maximum allowed width for image '%value%' should be '%maxwidth%' but '%width%' detected" => "Максималната разрешена широчина за картинката '%value%' е '%maxwidth%', а е засечена '%width%'",
    "Minimum expected width for image '%value%' should be '%minwidth%' but '%width%' detected" => "Минималната разрешена широчина за картинката '%value%' е '%minwidth%', а е засечена '%width%'",
    "Maximum allowed height for image '%value%' should be '%maxheight%' but '%height%' detected" => "Максималната разрешена височина за картинката '%value%' е '%maxheight%', а е засечена '%height%'",
    "Minimum expected height for image '%value%' should be '%minheight%' but '%height%' detected" => "Минималната разрешена височина за картинката '%value%' е '%minheight%', а е засечена '%height%'",
    "The size of image '%value%' could not be detected" => "Размерът на картинката '%value%' не може да бъде засечен",
    "File '%value%' can not be read" => "Файлът '%value%' не може да бъде отворен",

    // Zend_Validate_File_IsCompressed
    "File '%value%' is not compressed, '%type%' detected" => "Файлът '%value%' не е компресиран, засечен е тип '%type%'",
    "The mimetype of file '%value%' could not be detected" => "Mimetype на файлът '%value%' не може да бъде засечен",
    "File '%value%' can not be read" => "Файлът '%value%' не може да бъде отворен",

    // Zend_Validate_File_IsImage
    "File '%value%' is no image, '%type%' detected" => "Файлът '%value%' не е картинка, засечен тип: '%type%'",
    "The mimetype of file '%value%' could not be detected" => "Mimetype на файлът '%value%' не може да бъде засечен",
    "File '%value%' can not be read" => "Файлът '%value%' не може да бъде отворен",

    // Zend_Validate_File_Md5
    "File '%value%' does not match the given md5 hashes" => "File '%value%' does not match the given md5 hashes",
    "A md5 hash could not be evaluated for the given file" => "A md5 hash could not be evaluated for the given file",
    "File '%value%' could not be found" => "File '%value%' could not be found",

    // Zend_Validate_File_MimeType
    "File '%value%' has a false mimetype of '%type%'" => "Файлът '%value%' има грешен mimetypе - '%type%'",
    "The mimetype of file '%value%' could not be detected" => "Mimetype на '%value%' не може да бъде засечен",
    "File '%value%' can not be read" => "Файлът '%value%' не може да бъде отворен",

    // Zend_Validate_File_NotExists
    "File '%value%' exists" => "Файлът '%value%' не съществува",

    // Zend_Validate_File_Sha1
    "File '%value%' does not match the given sha1 hashes" => "File '%value%' does not match the given sha1 hashes",
    "A sha1 hash could not be evaluated for the given file" => "A sha1 hash could not be evaluated for the given file",
    "File '%value%' could not be found" => "File '%value%' could not be found",

    // Zend_Validate_File_Size
    "Maximum allowed size for file '%value%' is '%max%' but '%size%' detected" => "Файлът надвишава максималният разрешен размер(%max%). Размерът на '%value%' е %size%",
    "Minimum expected size for file '%value%' is '%min%' but '%size%' detected" => "Файлът е под минималният разрешен размер(%min%). Размерът на '%value%' е %size%",
    "File '%value%' could not be found" => "Файлът '%value%' не е открит",

    // Zend_Validate_File_Upload
    "File '%value%' exceeds the defined ini size" => "Файлът надвишава максималният разрешен размер",
    "File '%value%' exceeds the defined form size" => "Файлът надвишава максималният размер",
    "File '%value%' was only partially uploaded" => "Файлът '%value%' беше качен частично",
    "File '%value%' was not uploaded" => "Файлът '%value%' не беше качен",
    "No temporary directory was found for file '%value%'" => "Не беше открита временна папка за '%value%'",
    "File '%value%' can't be written" => "Не може да се пище във файлът '%value%'",
    "A PHP extension returned an error while uploading the file '%value%'" => "Разширение на PHP извести за грешка при качването на '%value%'",
    "File '%value%' was illegally uploaded. This could be a possible attack" => "Файлът '%value%' беше качен незаконно. Възможно е това да е атака",
    "File '%value%' was not found" => "Файлът '%value%' не беше открит",
    "Unknown error while uploading file '%value%'" => "Недефинирана грешка при опит за кчване на '%value%'",

    // Zend_Validate_File_WordCount
    "Too much words, maximum '%max%' are allowed but '%count%' were counted" => "Too much words, maximum '%max%' are allowed but '%count%' were counted",
    "Too less words, minimum '%min%' are expected but '%count%' were counted" => "Too less words, minimum '%min%' are expected but '%count%' were counted",
    "File '%value%' could not be found" => "File '%value%' could not be found",

    // Zend_Validate_Float
    "Invalid type given, value should be float, string, or integer" => "Invalid type given, value should be float, string, or integer",
    "'%value%' does not appear to be a float" => "'%value%' не е от тип float",

    // Zend_Validate_GreaterThan
    "'%value%' is not greater than '%min%'" => "'%value%' не е по-голямо от '%min%'",

    // Zend_Validate_Hex
    "Invalid type given, value should be a string" => "Грешка! Сойността трябва да е string",
    "'%value%' has not only hexadecimal digit characters" => "'%value%' не е само с шестнайсетични знаци",

    // Zend_Validate_Hostname
    "Invalid type given, value should be a string" => "Invalid type given, value should be a string",
    "'%value%' appears to be an IP address, but IP addresses are not allowed" => "'%value%' appears to be an IP address, but IP addresses are not allowed",
    "'%value%' appears to be a DNS hostname but cannot match TLD against known list" => "'%value%' appears to be a DNS hostname but cannot match TLD against known list",
    "'%value%' appears to be a DNS hostname but contains a dash in an invalid position" => "'%value%' appears to be a DNS hostname but contains a dash in an invalid position",
    "'%value%' appears to be a DNS hostname but cannot match against hostname schema for TLD '%tld%'" => "'%value%' appears to be a DNS hostname but cannot match against hostname schema for TLD '%tld%'",
    "'%value%' appears to be a DNS hostname but cannot extract TLD part" => "'%value%' appears to be a DNS hostname but cannot extract TLD part",
    "'%value%' does not match the expected structure for a DNS hostname" => "'%value%' does not match the expected structure for a DNS hostname",
    "'%value%' does not appear to be a valid local network name" => "Грешен адрес",
    "'%value%' appears to be a local network name but local network names are not allowed" => "Грешен адрес",
    "'%value%' appears to be a DNS hostname but the given punycode notation cannot be decoded" => "Грешен адрес",

    // Zend_Validate_Iban
    "Unknown country within the IBAN '%value%'" => "Unknown country within the IBAN '%value%'",
    "'%value%' has a false IBAN format" => "'%value%' has a false IBAN format",
    "'%value%' has failed the IBAN check" => "'%value%' has failed the IBAN check",

    // Zend_Validate_Identical
    "The token '%token%' does not match the given token '%value%'" => "Заявката беше блокирана",
    "No token was provided to match against" => "Заявката беше блокирана",

    // Zend_Validate_InArray
    "'%value%' was not found in the haystack" => "'%value%' was not found in the haystack",

    // Zend_Validate_Int
    "Invalid type given, value should be string or integer" => "Invalid type given, value should be string or integer",
    "'%value%' does not appear to be an integer" => "'%value%' does not appear to be an integer",

    // Zend_Validate_Ip
    "Invalid type given, value should be a string" => "Invalid type given, value should be a string",
    "'%value%' does not appear to be a valid IP address" => "'%value%' does not appear to be a valid IP address",

    // Zend_Validate_Isbn
    "'%value%' is no valid ISBN number" => "'%value%' is no valid ISBN number",

    // Zend_Validate_LessThan
    "'%value%' is not less than '%max%'" => "'%value%' is not less than '%max%'",

    // Zend_Validate_NotEmpty
    "Invalid type given, value should be float, string, array, boolean or integer" => "Invalid type given, value should be float, string, array, boolean or integer",
    "Value is required and can't be empty" => "Полето е задължително",

    // Zend_Validate_PostCode
    "Invalid type given, value should be string or integer" => "Invalid type given, value should be string or integer",
    "'%value%' does not appear to be an postal code" => "'%value%' does not appear to be an postal code",

    // Zend_Validate_Regex
    "Invalid type given, value should be string, integer or float" => "Invalid type given, value should be string, integer or float",
    "'%value%' does not match against pattern '%pattern%'" => "'%value%' does not match against pattern '%pattern%'",

    // Zend_Validate_Sitemap_Changefreq
    "'%value%' is no valid sitemap changefreq" => "'%value%' is no valid sitemap changefreq",

    // Zend_Validate_Sitemap_Lastmod
    "'%value%' is no valid sitemap lastmod" => "'%value%' is no valid sitemap lastmod",

    // Zend_Validate_Sitemap_Loc
    "'%value%' is no valid sitemap location" => "'%value%' is no valid sitemap location",

    // Zend_Validate_Sitemap_Priority
    "'%value%' is no valid sitemap priority" => "'%value%' is no valid sitemap priority",

    // Zend_Validate_StringLength
    "Invalid type given, value should be a string" => "Invalid type given, value should be a string",
    "'%value%' is less than %min% characters long" => "Грешка! Минимум %min% знака",
    "'%value%' is more than %max% characters long" => "Грешка! Максимум %max% знака",
    
    //Zend_Captcha
    "Empty captcha value" => "Грешка! Неправилен код",
    "Captcha ID field is missing" => "Грешка! ",
    "Captcha value is wrong" => "Грешка! Неправилен код",
);
