<?php

$alpha_layout_class = "col-md-8";
$alpha_text_class = "";
if(!is_active_sidebar("sidebar-1")) {
  $alpha_layout_class = "col-md-10 offset-md-1";
  $alpha_text_class = "text-center";
}

?>


<?php get_header(); ?>

<!-- Body Classes -->
<body <?php body_class(); ?> >
<!-- Hero Section -->
<?php get_template_part("/template-parts/common-part/hero"); ?>

<div class="container">
  <div class="row">
    <div class="<?php echo $alpha_layout_class ?>" >
      <div class="posts">
        <?php
          while ( have_posts() ) {
            the_post();
        ?>
          <!-- Post Class -->
          <div class="post" <?php post_class(); ?> >
              <div class="container">
                  <div class="row">
                      <div class="col-md-12">
                        <h2 class="post-title <?php echo $alpha_text_class ?>">
                            <!-- Post Title -->
                            <?php the_title(); ?>
                          </h2>
                        <p class="<?php echo $alpha_text_class ?>">
                              <strong>
                                <!-- Author Name -->
                                <?php the_author(); ?>
                              </strong><br/>
                              <!-- Show Date -->
                              <?php echo get_the_date(); ?>
                          </p>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <p>
                            <!-- Show Thumbnail Image -->
                              <?php
                                if ( !class_exists( 'Attachments' ) ) {
                                                if ( has_post_thumbnail() ) {
                                                    $thumbnail_url = get_the_post_thumbnail_url( null, "large" );
                                                    printf( '<a class="popup" href="%s" data-featherlight="image">', $thumbnail_url );
                                                    the_post_thumbnail( "large", array( "class" => "img-fluid" ) );
                                                    echo '</a>';
                                                }
                                            }
                              ?>
                          </p>
                          <!-- Post Description -->
                          <p>
                            <?php
                            the_content();

                            // One Page/Post Pagination -->
                            wp_link_pages();

                          // Post Pagination -->
                            next_post_link();
                            echo "<br/>";
                            previous_post_link();

                            ?>
                          </p>
                      </div>

                      <!-- Author Section -->
                      <div class="authorsection">
                        <div class="row">
                          <div class="col-md-3 authorimage">
                            <?php
                              echo get_avatar(get_the_author_meta("id"));
                            ?>
                          </div>
                          <div class="col-md-9">
                            <h4>
                              <?php
                                echo get_the_author_meta("display_name");
                              ?>
                              <p>
                              <?php
                                echo get_the_author_meta("description");
                              ?>
                              </p>
                            </h4>
                          </div>
                        </div>
                      </div>

                      <!-- Post Comments -->
                      <?php if(comments_open()): ?>
                      <div class="col-md-10 offset-md-1">
                      <?php
                            // comments_template();
                        ?>
                      </div>
                      <?php endif; ?>
                  </div>
              </div>
          </div>
          <?php
        }
      ?>

      <div class="container post-pagination">
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-8">
            <!-- Post Pagination -->
            <?php
              the_posts_pagination(array(
                "screen_reader_text" => ' ',
                "prev_text" => "New Posts",
                "next_text" => "Old Posts"
              ));
            ?>
          </div>
        </div>
      </div>
      </div>
    </div>


    <?php
      if(is_active_sidebar("sidebar-1")):
    ?>
    <div class="col-md-4">
      <!-- Right Sidebar -->
      <?php
        if(is_active_sidebar("sidebar-1")){
          dynamic_sidebar("sidebar-1");
        }
      ?>
    </div>
    <?php endif; ?>


  </div>
</div>

<?php get_footer(); ?>
