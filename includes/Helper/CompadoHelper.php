<?php
namespace Compado\Products\Helper;

defined('ABSPATH') || exit;
use DOMDocument;
use DOMXPath;

class CompadoHelper
{
    /**
     * Extracts <ul> tags from an HTML string.
     *
     * @param string $html The HTML string to extract <ul> tags from.
     * @return string The extracted <ul> tags as a string.
     */
    public static function extract_ul_from_html($html): string
    {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXPath($dom);

        $ulList = $xpath->query('//ul');

        $listHtml = '';

        foreach ($ulList as $ul) {
            $listHtml .= $dom->saveHTML($ul);
        }

        libxml_clear_errors();

        $allowed_tags = array(
            'ul' => array(),
            'li' => array(),
            'p' => array(),
            'img' => array(
                'src' => true,
                'alt' => true,
                'style' => true,
                'width' => true,
                'height' => true,
            ),
        );

        return wp_kses_post($listHtml);
    }


}