<?php
/**
 * Updating VisualPlus
 *
 * @see VTCore_Wordpress_Factory_Updater
 * Class VTCore_Wordpress_Models_Updater
 */
class VTCore_Timeline_Updater
extends VTCore_Wordpress_Models_Updater {

  protected function update_1_4_0() {

    global $wpdb;

    // Try to recreate the timeline "end" using new shortcode rules
    $posts = $wpdb->get_results("
      SELECT ID, post_content
      FROM $wpdb->posts
      WHERE post_content
      LIKE '%[timeline%'
    ");

    $pattern = '\[(\[?)(timeline)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';

    foreach ($posts as $post) {
      $matches = array();
      preg_match_all('/'. $pattern .'/s', $post->post_content, $matches);

      if (isset($matches[0]) && !empty($matches[0])) {
        foreach ($matches[0] as $timeline) {
          $atts = shortcode_parse_atts($timeline);
          foreach($atts as $key => $value) {
            if ($key === 'ending_text') {
              $modified = str_replace(array(' ending_text="' . $value . '"', '[/timeline]'), array('', '[timeend][vc_column_text]' . $value . '[/vc_column_text][/timeend][/timeline]'), $timeline);
              $post->post_content = str_replace($timeline, $modified, $post->post_content);

              // Update the new end timeline
              $wpdb->query(
                $wpdb->prepare("
                    UPDATE $wpdb->posts
                    SET post_content = %s
                    WHERE ID = %d
                  ", array($post->post_content, $post->ID))
              );
              break;
            }
          }
        }
      }
    }

    return true;
  }
}