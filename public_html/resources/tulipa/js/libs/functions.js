function baseResourcesUrl(link) 
{
    var newLink = $('link[rel=resources]').attr('href') + '/' + link;
    return newLink;
}

function baseUrl(file) 
{
    var firstChar = file.charAt(0);    
    var returnString = config.baseUrl;    
    if (firstChar != '/') {
        returnString += '/';
    }    
    return returnString + file;
}

function translate(msgstr) 
{
    return jQuery.gt.gettext(msgstr);
}