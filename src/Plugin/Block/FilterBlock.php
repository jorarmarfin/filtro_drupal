<?php

namespace Drupal\filternews\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'FilterBlock' block.
 *
 * @Block(
 *  id = "filter_block_news",
 *  admin_label = @Translation("Filtro para noticias"),
 * )
 */
class FilterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return \Drupal::formBuilder()->getForm('Drupal\filternews\Form\FilterForm');
  }

}
