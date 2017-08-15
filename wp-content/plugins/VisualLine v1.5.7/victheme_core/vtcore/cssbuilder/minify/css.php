<?php
/**
 * CSS Minifier
 *
 * Usage - VTCore_CSSBuilder_Minify_Css::minify($css);
 *
 * @author jason.xie@victheme.com
 */
class VTCore_CSSBuilder_Minify_CSS {

    /**
     * Takes a string containing css and
     * removes unneeded characters in
     * order to shrink the code without
     * altering it's functionality.
     *
     * Ripped off from drupal aggregation
     */
    public static function minify($css) {

      // Perform some safe CSS optimizations.
      // Regexp to match comment blocks.
      $comment = '/\*[^*]*\*+(?:[^/*][^*]*\*+)*/';

      // Regexp to match double quoted strings.
      $double_quot = '"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"';

      // Regexp to match single quoted strings.
      $single_quot = "'[^'\\\\]*(?:\\\\.[^'\\\\]*)*'";

      // Strip all comment blocks, but keep double/single quoted strings.
      $css = preg_replace("<($double_quot|$single_quot)|$comment>Ss", "$1", $css);

      // Remove certain whitespace.
      // There are different conditions for removing leading and trailing
      // whitespace.
      // @see http://php.net/manual/regexp.reference.subpatterns.php
      $css = preg_replace('<
          # Strip leading and trailing whitespace.
            \s*([@{};,])\s*
          # Strip only leading whitespace from:
          # - Closing parenthesis: Retain "@media (bar) and foo".
          | \s+([\)])
          # Strip only trailing whitespace from:
          # - Opening parenthesis: Retain "@media (bar) and foo".
          # - Colon: Retain :pseudo-selectors.
          | ([\(:])\s+
        >xS',

      // Only one of the three capturing groups will match, so its reference
      // will contain the wanted value and the references for the
      // two non-matching groups will be replaced with empty strings.
      '$1$2$3', $css);

      // End the file with a new line.
      $css = trim($css);
      $css .= "\n";


      return $css;
    }


}
