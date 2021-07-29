<?php

// For Development Prevent Caching
if ( site_url() == "http://webdevone.local/" ) {
    define( "VERSION", time() );
} else {
    define( "VERSION", wp_get_theme()->get( "Version" ) );
}


// Basic configuration for Theme
function alpha_bootstrapping(){
  load_theme_textdomain("alpha");

  $alpha_custom_logo_details = array(
    'width' =>'100px',
    'height' =>'100px'
  );
  add_theme_support("custom-logo", $alpha_custom_logo_details);

    add_theme_support("custom-background");
  add_theme_support("post-thumbnails");
  add_theme_support("title-tag");

  $alpha_custom_header_details = array(
    'header-text' => true,
    'default-text-color' => '#222',
    'width' => 1200,
    'height' => 600,
    'flex-height' => true,
  );
  add_theme_support("custom-header", $alpha_custom_header_details);

  register_nav_menu("topmenu",__("Top Menu","alpha"));
  register_nav_menu("footermenu",__("Footer Menu","alpha"));
  register_nav_menu("socialmenu",__("Social Menu","alpha"));
  register_nav_menu("sidebarmenu",__("Sidebar Menu","alpha"));
}
add_action("after_setup_theme", "alpha_bootstrapping");


// Load style and script files for post/page
function alpha_assets(){
  wp_enqueue_style("alpha", get_stylesheet_uri(), null, VERSION);
  wp_enqueue_style("bootstrap", "//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css");
  wp_enqueue_style( "featherlight-css", "//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css" );

  wp_enqueue_script( "featherlight-js", "//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js", array( "jquery" ), "0.0.1", true );
  wp_enqueue_script( "alpha-main2", get_theme_file_uri( "/assets/js/main.js" ), array(
        "jquery",
        "featherlight-js"
    ), VERSION, true );

}
add_action("wp_enqueue_scripts", "alpha_assets");


// Sidebar Widget Function Register
function alpha_sidebar(){
  register_sidebar(
    array(
      'name' => __( 'Default Sidebar','alpha' ),
      'id' => 'sidebar-1',
      'description' => __( 'Right Sidebar','alpha' ),
      'before_widget' => '<section id="%1&s" class="widget %2&s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>'
    )
  );
  register_sidebar(
    array(
      'name' => __( 'Footer Left','alpha' ),
      'id' => 'footer-left',
      'description' => __( 'Bottom Footer Left','alpha' ),
      'before_widget' => '<section id="%1&s" class="widget %2&s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>'
    )
  );
  register_sidebar(
    array(
      'name' => __( 'Footer Center','alpha' ),
      'id' => 'footer-center',
      'description' => __( 'Bottom Footer Center','alpha' ),
      'before_widget' => '<section id="%1&s" class="widget %2&s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>'
    )
  );
  register_sidebar(
    array(
      'name' => __( 'Footer Right','alpha' ),
      'id' => 'footer-right',
      'description' => __( 'Bottom Footer Right','alpha' ),
      'before_widget' => '<section id="%1&s" class="widget %2&s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>'
    )
  );
}
add_action("widgets_init","alpha_sidebar");


// Password Protected Post Register
function alpha_the_excerpt($excerpt){
  if(!post_password_required()){
    return $excerpt;
  }else {
    echo get_the_password_form();
  }
}
add_filter("the_excerpt","alpha_the_excerpt");

function alpha_protected_title_change(){
  return "%s";
}
add_filter("protected_title_format","alpha_protected_title_change");


// Top Menu List Item Class Add
function alpha_menu_item_class($classes, $item, $args){
  if ( 'topmenu' === $args->theme_location ) {
        $classes[] = 'list-inline-item';
    }
  return $classes;
}
add_filter("nav_menu_css_class","alpha_menu_item_class", 10, 3);


// Footer Menu List Item Class Add
function alpha_menu_footer_class($classes, $item, $args){
  if ( 'socialmenu' === $args->theme_location ) {
        $classes[] = 'list-inline-item';
    }
  return $classes;
}
add_filter("nav_menu_css_class","alpha_menu_footer_class", 10, 3);


// Load About page Background Image on Head
function alpha_about_page_template_background(){
  if(is_page()){
    $alpha_feat_image = get_the_post_thumbnail_url(null,"large");
  }
?>
<style>
    .page-header{
      background-image: url(<?php echo $alpha_feat_image;?>);
      background-size: cover;
    }
    .page-header h1.heading a {
      color: #<?php echo get_header_textcolor(); ?>

      <?php
        if(!display_header_text()){
          echo "display: none;";
        }
      ?>
    }
</style>
<?php

// Load Background Image Globally
if(is_front_page()){
  if(current_theme_supports("custom-header")){
?>
  <style>
    .header {
      background-image: url(<?php echo header_image(); ?>);
      background-size: cover;
      background-position: center;
      margin-bottom: 80px;
      padding-bottom: 60px;
    }
    .header h1.heading a {
      color: #<?php echo get_header_textcolor(); ?>

      <?php
        if(!display_header_text()){
          echo "display: none;";
        }
      ?>
    }
  </style>
<?php
  }
}
}
add_action("wp_head","alpha_about_page_template_background", 100);


?>
