<?php 
namespace Aerolinea\Blocks\Section;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('asb/section', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));
}

function render_dynamic_block($attributes) {
    ob_start(); // Turn on output buffering

    /* BEGIN HTML OUTPUT */
    $imgSrc = $attributes['image']['url'];
    $imgAlt = $attributes['image']['title'];
    $title = $attributes['title'];
    $content = $attributes['content'];
    $linkTitle = $attributes['link']['title'];
    $linkUrl = $attributes['link']['url'];
    $isRight = $attributes['isRight'] ? 'right' : '';
    $isTitle = $attributes['hideTitle'];
    $isContent = $attributes['hideContent'];
    $isLink = $attributes['hideLink'];
    $bg_color = $attributes['bgColor'];
    $v_aling = $attributes['vAlignment'];
    $id = $attributes['sectionID']? 'id="' .$attributes['sectionID'].'"': '';
    $img_height = $attributes['imgHeight']? $attributes['imgHeight'] : 50;
    $is_bottom = $attributes['isBottom'] ? 'last' : '';
    $no_padding = $attributes['noPadding'] ? 'no-pd':'';
  ?>
    <section <?php echo $id; ?> class="mensajes <?php echo $isRight . ' ' . $no_padding; ?>" style="--bg-color:<?php echo $bg_color; ?>;--v-alingment:<?php echo $v_aling; ?>; --img-height:<?php echo $img_height; ?>vh;">
      <img class="mensajes__img <?php echo $is_bottom; ?>" src="<?php echo $imgSrc; ?>" alt="<?php echo $imgAlt; ?>">
      <?php if(!$isTitle):?>
        <h2 class="mensajes__title " ><?php echo $title; ?></h2>
      <?php endif; ?>
      <?php if(!$isContent):?>
        <div class="mensajes__content" ><?php echo $content; ?></div>
      <?php endif; ?>
      <?php if(!$isLink):?>
        <a class="mensajes__link" href="<?php echo $linkUrl; ?>" target="_blank" rel="noopener noreferrer">
          <?php echo $linkTitle; ?>
        </a>
      <?php endif; ?>
    </section>
  <?php
  /* END HTML OUTPUT */

  $output = ob_get_contents(); // collect output
  ob_end_clean(); // Turn off ouput buffer

  return $output; // Print output
  // return $attributes['title'];
  // return 'totle';
}