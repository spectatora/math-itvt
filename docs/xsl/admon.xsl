<?xml version='1.0'?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:template name="nongraphical.admonition">
        <div class="ui-widget">
            <div class="note ui-state-highlight ui-corner-all"> 
                <span class="ui-icon ui-icon-info"></span>
                <p>
                    <xsl:if test="$admon.textlabel != 0 or title or info/title">
                        <strong>
                            <xsl:call-template name="anchor"/>
                            <xsl:apply-templates select="." mode="object.title.markup"/>
                        </strong>
                        <br />
                    </xsl:if>
                    <xsl:apply-templates/>
                </p>
            </div>
        </div>
    </xsl:template>
    
</xsl:stylesheet>
