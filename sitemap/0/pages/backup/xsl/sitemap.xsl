<?xml version="1.0" encoding="UTF-8"?><xsl:stylesheet version="2.0" xmlns:html="http://www.w3.org/TR/REC-html40" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"><xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/><xsl:template match="/"><html xmlns="http://www.w3.org/1999/xhtml"><head><title>pages sitemap</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <style type="text/css"> body { font-family: arial; font-size: 13px; color: #545353; } h1{ font-size: 18px; } #container { margin-left:5%; margin-right:5%; margin-top:2.5%; } .linkBlock{ width:100%; vertical-align:top; margin-right:1.25%; margin-top:10px; padding-top:.5%; border-top:1px solid #DBDBDB; } .image{ width:10%; margin-right:1.25%; box-shadow: 0px 0px 0px, 0 2px 3px 0; color:#000; margin-bottom:1.5%; margin-top:.5%; display:inline-block; } .content{ vertical-align:top; display:inline-block; } .contentp{ margin-top:2px; color:#737373; } .copyright{ text-align:center; margin-top:30px; color:#737373; } .rights{ text-align:center; color:#737373; } .url{ font-size: 12px; margin-top:6%; padding-bottom:.5%; overflow:auto; } a{ text-decoration:none; font-weight:bold; color:#737373; } a:active{ text-decoration:none; font-weight:bold; color:red; } ::-webkit-scrollbar {height:10px;width:10px;} ::-webkit-scrollbar-track {background-color: #DBDBDB;}::-webkit-scrollbar-thumb {background-color: rgba(0, 0, 0, 0.2);}::-webkit-scrollbar-corner {background-color: black;}::-webkit-scrollbar { height:10px;width:10px; } ::-webkit-scrollbar-track { background-color: #DBDBDB; } ::-webkit-scrollbar-thumb { background-color: #737373; }::-webkit-scrollbar-corner { background-color: #DBDBDB; }  @media screen and (max-width: 850px) {  .image{ width:30%; margin-right:1.25%; box-shadow: 0px 0px 0px, 0 2px 3px 0; color:#000; margin-bottom:1.5%; margin-top:.5%; display:inline-block; } } </style> </head> <body> <div id="container"><h1>pages sitemap</h1><p>This sitemap was generated by <a href="http://gcrdev.com" target="_blank">GCRdev</a> and is for search engine reference.<br/> <a href="http://sitemaps.org" target="_blank">sitemaps.org</a> contains further information regarding sitemaps. </p> <xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &lt; 1"> <p> <xsl:value-of select="count(sitemap:urlset/sitemap:url)"/> URL<xsl:if test="count(sitemap:urlset/sitemap:url) != 1">s</xsl:if> found in this sitemap. </p><p><a href="/sitemap/0/sitemap-index.xml">sitemap index</a></p>
	<a href="/sitemap/0/pages/sitemap-index.xml">pages index</a><xsl:variable name="lower" select="'abcdefghijklmnopqrstuvwxyz'"/><xsl:variable name="upper" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'"/><xsl:for-each select="sitemap:urlset/sitemap:url"><div class="linkBlock"><xsl:variable name="itemURL"><xsl:value-of select="sitemap:loc"/> </xsl:variable> <xsl:for-each select="image:image">  <xsl:if test="position() &lt;= 1"> <xsl:variable name="imgSRC"> <xsl:value-of select="image:loc"/> </xsl:variable> <xsl:variable name="imgTitle"> <xsl:value-of select="image:title"/> </xsl:variable> <a href="{$imgSRC}" target="_blank"><img src="{$imgSRC}" class="image" title="{$imgTitle}" alt="{$imgTitle}" /></a> </xsl:if>  </xsl:for-each><div class="content"> <div class="url"><a href="{$itemURL}" target="_blank"><xsl:value-of select="sitemap:loc"/></a></div><div class="contentp"><xsl:value-of select="count(image:image)"/> image<xsl:if test="count(image:image) != 1">s</xsl:if></div><div class="contentp"> change frequency: <b><xsl:value-of select="sitemap:changefreq"/></b> </div> <div class="contentp"> priority: <b><xsl:value-of select="sitemap:priority"/></b></div><xsl:if test="count(sitemap:lastmod) != 0"><div class="contentp"> lastmod: <b><xsl:value-of select="sitemap:lastmod"/></b></div></xsl:if></div></div></xsl:for-each></xsl:if></div>  <div class="copyright"> <xsl:text> &#169;</xsl:text>2017 GCRdev - All rights reserved</div></body></html></xsl:template></xsl:stylesheet>