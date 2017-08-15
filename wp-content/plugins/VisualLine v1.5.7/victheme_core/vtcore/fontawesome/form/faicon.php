<?php
/**
 * Helper Class for building the Fontawesome
 * icon selector.
 *
 * This HTML output is compatible with the icon picker js.
 *
 * @author jason.xie@victheme.com
 * @see VTCore_Form_Interface interface
 */
class VTCore_Fontawesome_Form_faIcon
extends VTCore_Fontawesome_Form_Base
implements VTCore_Form_Interface {


  /**
   * Declaring icon type
   * base on fontawesome 4.2.0
   */
  protected $icons = array(
    'adjust' , 'anchor' , 'archive' , 'area-chart' , 'arrows' , 'arrows-h' , 'arrows-v' , 'asterisk' , 'at' , 'automobile' , 'ban' , 'bank' , 'bar-chart' , 'bar-chart-o' , 'barcode' , 'bars' , 'beer' , 'bell' , 'bell-o' , 'bell-slash' , 'bell-slash-o' , 'bicycle' , 'binoculars' , 'birthday-cake' , 'bolt' , 'bomb' , 'book' , 'bookmark' , 'bookmark-o' , 'briefcase' , 'bug' , 'building' , 'building-o' , 'bullhorn' , 'bullseye' , 'bus' , 'cab' , 'calculator' , 'calendar' , 'calendar-o' , 'camera' , 'camera-retro' , 'car' , 'caret-square-o-down' , 'caret-square-o-left' , 'caret-square-o-right' , 'caret-square-o-up' , 'cc' , 'certificate' , 'check' , 'check-circle' , 'check-circle-o' , 'check-square' , 'check-square-o' , 'child' , 'circle' , 'circle-o' , 'circle-o-notch' , 'circle-thin' , 'clock-o' , 'close' , 'cloud' , 'cloud-download' , 'cloud-upload' , 'code' , 'code-fork' , 'coffee' , 'cog' , 'cogs' , 'comment' , 'comment-o' , 'comments' , 'comments-o' , 'compass' , 'copyright' , 'credit-card' , 'crop' , 'crosshairs' , 'cube' , 'cubes' , 'cutlery' , 'dashboard' , 'database' , 'desktop' , 'dot-circle-o' , 'download' , 'edit' , 'ellipsis-h' , 'ellipsis-v' , 'envelope' , 'envelope-o' , 'envelope-square' , 'eraser' , 'exchange' , 'exclamation' , 'exclamation-circle' , 'exclamation-triangle' , 'external-link' , 'external-link-square' , 'eye' , 'eye-slash' , 'eyedropper' , 'fax' , 'female' , 'fighter-jet' , 'file-archive-o' , 'file-audio-o' , 'file-code-o' , 'file-excel-o' , 'file-image-o' , 'file-movie-o' , 'file-pdf-o' , 'file-photo-o' , 'file-picture-o' , 'file-powerpoint-o' , 'file-sound-o' , 'file-video-o' , 'file-word-o' , 'file-zip-o' , 'film' , 'filter' , 'fire' , 'fire-extinguisher' , 'flag' , 'flag-checkered' , 'flag-o' , 'flash' , 'flask' , 'folder' , 'folder-o' , 'folder-open' , 'folder-open-o' , 'frown-o' , 'futbol-o' , 'gamepad' , 'gavel' , 'gear' , 'gears' , 'gift' , 'glass' , 'globe' , 'graduation-cap' , 'group' , 'hdd-o' , 'headphones' , 'heart' , 'heart-o' , 'history' , 'home' , 'image' , 'inbox' , 'info' , 'info-circle' , 'institution' , 'key' , 'keyboard-o' , 'language' , 'laptop' , 'leaf' , 'legal' , 'lemon-o' , 'level-down' , 'level-up' , 'life-bouy' , 'life-buoy' , 'life-ring' , 'life-saver' , 'lightbulb-o' , 'line-chart' , 'location-arrow' , 'lock' , 'magic' , 'magnet' , 'mail-forward' , 'mail-reply' , 'mail-reply-all' , 'male' , 'map-marker' , 'meh-o' , 'microphone' , 'microphone-slash' , 'minus' , 'minus-circle' , 'minus-square' , 'minus-square-o' , 'mobile' , 'mobile-phone' , 'money' , 'moon-o' , 'mortar-board' , 'music' , 'navicon' , 'newspaper-o' , 'paint-brush' , 'paper-plane' , 'paper-plane-o' , 'paw' , 'pencil' , 'pencil-square' , 'pencil-square-o' , 'phone' , 'phone-square' , 'photo' , 'picture-o' , 'pie-chart' , 'plane' , 'plug' , 'plus' , 'plus-circle' , 'plus-square' , 'plus-square-o' , 'power-off' , 'print' , 'puzzle-piece' , 'qrcode' , 'question' , 'question-circle' , 'quote-left' , 'quote-right' , 'random' , 'recycle' , 'refresh' , 'remove' , 'reorder' , 'reply' , 'reply-all' , 'retweet' , 'road' , 'rocket' , 'rss' , 'rss-square' , 'search' , 'search-minus' , 'search-plus' , 'send' , 'send-o' , 'share' , 'share-alt' , 'share-alt-square' , 'share-square' , 'share-square-o' , 'shield' , 'shopping-cart' , 'sign-in' , 'sign-out' , 'signal' , 'sitemap' , 'sliders' , 'smile-o' , 'soccer-ball-o' , 'sort' , 'sort-alpha-asc' , 'sort-alpha-desc' , 'sort-amount-asc' , 'sort-amount-desc' , 'sort-asc' , 'sort-desc' , 'sort-down' , 'sort-numeric-asc' , 'sort-numeric-desc' , 'sort-up' , 'space-shuttle' , 'spinner' , 'spoon' , 'square' , 'square-o' , 'star' , 'star-half' , 'star-half-empty' , 'star-half-full' , 'star-half-o' , 'star-o' , 'suitcase' , 'sun-o' , 'support' , 'tablet' , 'tachometer' , 'tag' , 'tags' , 'tasks' , 'taxi' , 'terminal' , 'thumb-tack' , 'thumbs-down' , 'thumbs-o-down' , 'thumbs-o-up' , 'thumbs-up' , 'ticket' , 'times' , 'times-circle' , 'times-circle-o' , 'tint' , 'toggle-down' , 'toggle-left' , 'toggle-off' , 'toggle-on' , 'toggle-right' , 'toggle-up' , 'trash' , 'trash-o' , 'tree' , 'trophy' , 'truck' , 'tty' , 'umbrella' , 'university' , 'unlock' , 'unlock-alt' , 'unsorted' , 'upload' , 'user' , 'users' , 'video-camera' , 'volume-down' , 'volume-off' , 'volume-up' , 'warning' , 'wheelchair' , 'wifi' , 'wrench' , 'file' , 'file-o' , 'file-text' , 'file-text-o' , 'cc-amex' , 'cc-discover' , 'cc-mastercard' , 'cc-paypal' , 'cc-stripe' , 'cc-visa' , 'google-wallet' , 'paypal' , 'bitcoin' , 'btc' , 'cny' , 'dollar' , 'eur' , 'euro' , 'gbp' , 'ils' , 'inr' , 'jpy' , 'krw' , 'rmb' , 'rouble' , 'rub' , 'ruble' , 'rupee' , 'shekel' , 'sheqel' , 'try' , 'turkish-lira' , 'usd' , 'won' , 'yen' , 'align-center' , 'align-justify' , 'align-left' , 'align-right' , 'bold' , 'chain' , 'chain-broken' , 'clipboard' , 'columns' , 'copy' , 'cut' , 'dedent' , 'files-o' , 'floppy-o' , 'font' , 'header' , 'indent' , 'italic' , 'link' , 'list' , 'list-alt' , 'list-ol' , 'list-ul' , 'outdent' , 'paperclip' , 'paragraph' , 'paste' , 'repeat' , 'rotate-left' , 'rotate-right' , 'save' , 'scissors' , 'strikethrough' , 'subscript' , 'superscript' , 'table' , 'text-height' , 'text-width' , 'th' , 'th-large' , 'th-list' , 'underline' , 'undo' , 'unlink' , 'angle-double-down' , 'angle-double-left' , 'angle-double-right' , 'angle-double-up' , 'angle-down' , 'angle-left' , 'angle-right' , 'angle-up' , 'arrow-circle-down' , 'arrow-circle-left' , 'arrow-circle-o-down' , 'arrow-circle-o-left' , 'arrow-circle-o-right' , 'arrow-circle-o-up' , 'arrow-circle-right' , 'arrow-circle-up' , 'arrow-down' , 'arrow-left' , 'arrow-right' , 'arrow-up' , 'arrows-alt' , 'caret-down' , 'caret-left' , 'caret-right' , 'caret-up' , 'chevron-circle-down' , 'chevron-circle-left' , 'chevron-circle-right' , 'chevron-circle-up' , 'chevron-down' , 'chevron-left' , 'chevron-right' , 'chevron-up' , 'hand-o-down' , 'hand-o-left' , 'hand-o-right' , 'hand-o-up' , 'long-arrow-down' , 'long-arrow-left' , 'long-arrow-right' , 'long-arrow-up' , 'backward' , 'compress' , 'eject' , 'expand' , 'fast-backward' , 'fast-forward' , 'forward' , 'pause' , 'play' , 'play-circle' , 'play-circle-o' , 'step-backward' , 'step-forward' , 'stop' , 'youtube-play' , 'adn' , 'android' , 'angellist' , 'apple' , 'behance' , 'behance-square' , 'bitbucket' , 'bitbucket-square' , 'codepen' , 'css3' , 'delicious' , 'deviantart' , 'digg' , 'dribbble' , 'dropbox' , 'drupal' , 'empire' , 'facebook' , 'facebook-square' , 'flickr' , 'foursquare' , 'ge' , 'git' , 'git-square' , 'github' , 'github-alt' , 'github-square' , 'gittip' , 'google' , 'google-plus' , 'google-plus-square' , 'hacker-news' , 'html5' , 'instagram' , 'ioxhost' , 'joomla' , 'jsfiddle' , 'lastfm' , 'lastfm-square' , 'linkedin' , 'linkedin-square' , 'linux' , 'maxcdn' , 'meanpath' , 'openid' , 'pagelines' , 'pied-piper' , 'pied-piper-alt' , 'pinterest' , 'pinterest-square' , 'qq' , 'ra' , 'rebel' , 'reddit' , 'reddit-square' , 'renren' , 'skype' , 'slack' , 'slideshare' , 'soundcloud' , 'spotify' , 'stack-exchange' , 'stack-overflow' , 'steam' , 'steam-square' , 'stumbleupon' , 'stumbleupon-circle' , 'tencent-weibo' , 'trello' , 'tumblr' , 'tumblr-square' , 'twitch' , 'twitter' , 'twitter-square' , 'vimeo-square' , 'vine' , 'vk' , 'wechat' , 'weibo' , 'weixin' , 'windows' , 'wordpress' , 'xing' , 'xing-square' , 'yahoo' , 'yelp' , 'youtube' , 'youtube-square' , 'ambulance' , 'h-square' , 'hospital-o' , 'medkit' , 'stethoscope' , 'user-md'
  );

  protected $context = array(

    'text' => false,
    'prefix' => false,
    'suffix' => false,
    'description' => false,
    'required' => false,
    'value' => false,
    'id' => false,
    'name' => false,
    'class' => array('form-icon-picker'),

    // BootStrap Rules
    'label' => true,

    // Wrapper element
    'type' => 'div',
    'attributes' => array(
      'class' => array('form-group', 'form-icons-iconpicker'),
      'data-prefix' => 'fa-',
      'data-base' => 'fa',
      'data-element' => 'i',
    ),

    // Internal use, Only override if needed
    'input_elements' => array(),

    'label_elements' => array(),
    'description_elements' => array(),
    'prefix_elements' => array(),
    'suffix_elements' => array(),
    'required_elements' => array(),
  );


  /**
   * Build a options valid for select element
   */
  protected function buildOptions() {

    // Load the fontawesome font CSS
    VTCore_Wordpress_Utility::loadAsset('font-awesome');
    VTCore_Wordpress_Utility::loadAsset('jquery-iconpicker');

    $this->options = array(
      false => __('No Icon', 'victheme_core'),
    );

    if ($this->getContext('iconset')) {
      $this->icons = $this->getContext('iconset');
    }

    $this->icons = array_unique($this->icons);
    sort($this->icons);

    foreach ($this->icons as $icon) {
      $this->options[$icon] = ucfirst(str_replace('-', ' ', $icon));
    }

    return $this;
  }

}