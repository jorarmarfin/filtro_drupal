<?php

namespace Drupal\popup\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a 'DefaultBlock' block.
 *
 * @Block(
 *  id = "popup_block",
 *  admin_label = @Translation("Pop Up"),
 * )
 */
class DefaultBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['popup_block_time'] = [
      '#type' => 'select',
      '#title' => $this->t('Tiempo'),
      '#multiple' => FALSE,
      '#required' => TRUE,
      '#description' => $this->t('Selecciona un formato'),
      '#options' => array
      (
        'popup_hora' => $this->t('Hora'),
        'popup_dia' => $this->t('Día')
       ),
      '#default_value' => ($this->configuration['popup_block_time']) ? $this->configuration['popup_block_time'] : 'popup_hora',
      '#size' => 5,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['popup_block_time'] = $form_state->getValue('popup_block_time');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['popup_block']['#markup'] = $this->htmlStructure();
    $build['#attached']['library'][] = 'popup/popup';

    return $build;
  }

  private function htmlStructure() {

    $query = \Drupal::entityQuery('node')
              ->condition('type', 'anuncios')
              ->condition('status', 1)
              ->sort('nid','DESC')
              ->range(0, 5);

    $nids = $query->execute();
    $nodes = entity_load_multiple('node', $nids);

    $data = '<ul class="popup-news">';
    foreach ($nodes as $node) {
      /*if has image*/
      if($node->field_imagen_anuncio[0]){
        $image = \Drupal\file\Entity\File::load($node->get('field_imagen_anuncio')->getValue()[0]['target_id']);
        $file_image = file_create_url($image->getFileUri());
        $data .= '
        <li class="popup-item">
          ';
        if($node->field_archivo[0]){
          $file = \Drupal\file\Entity\File::load($node->get('field_archivo')->getValue()[0]['target_id']);
          $file_url = file_create_url($file->getFileUri());
          $data .= '<a href="'.$file_url.'"><img src="'.$file_image.'" width="100%"></a>';
        }else{
          $url = Url::fromUri($node->get('field_enlace_anuncio')->getValue()[0]['uri']);
          if($url->isExternal()){
            $data .= '<a href="'.$url->toString().'" target="_blank"><img src="'.$file_image.'" width="100%"></a>';
          }else{
            $data .= '<a href="'.$url->toString().'"><img src="'.$file_image.'" width="100%"></a>';
          }
        }
        $data .= '</li>';
      }

      /*if not has image*/

      else{
        $data .= '
        <li class="popup-item">
          ';
        if($node->field_archivo[0]){
          $file = \Drupal\file\Entity\File::load($node->get('field_archivo')->getValue()[0]['target_id']);
          $file_url = file_create_url($file->getFileUri());
          $data .= '
          <label class="popup-label">Archivo:</label>
          <a href="'.$file_url.'">'.$file->get('filename')->value.'</a>
          ';
        }
        if($node->field_enlace_anuncio[0]){
          $url = Url::fromUri($node->get('field_enlace_anuncio')->getValue()[0]['uri']);
          if($url->isExternal()){
            $data .= '
            <label class="popup-label">Enlace:</label>
            <a href="'.$url->toString().'" target="_blank">Ver más</a>
            ';
          }else{
            $data .= '
            <label class="popup-label">Enlace:</label>
            <a href="'.$url->toString().'">Ver más</a>
            ';
          }
        }
        $data .= '</li>';
      }
    }
    $popup_points = '';
    if(count($nodes) > 0){
      $popup_points = '<div class="popup-points">';
      foreach ($nodes as $val) {
        $popup_points .= '<div class="popup-point"></div>';
      }
      $popup_points .= '</div>';
    }

    $html = '
    <div class="popup-content-head"><i class="fa fa-times-circle-o" aria-hidden="true"></i></div>
    <div class="popup-content-body">'.$data.'</div>
    ';

    $html .= $popup_points;
    return $html;
  }
}
