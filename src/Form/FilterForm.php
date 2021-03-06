<?php

namespace Drupal\filternews\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\search\SearchPageRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 *
 * @package Drupal\filternews\Form
 */
class FilterForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'filter_news';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['field_titulo_value'] = [
      '#type' => 'textfield',
      '#size' => 30,
      '#maxlength' => 128,
      '#placeholder' => 'Titulo',
      '#prefix' => '<div class="formulario-expuesto"><div class="form--inline clearfix">',
      ];
    $form['field_fecha_inicio_value'] = [
      '#type' => 'date',
      '#title' => 'Fecha de Inicio',
      ];

    $form['field_fecha_fin_value'] = [
      '#type' => 'date',
      '#title' => 'Fecha Final',
      ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Buscar',
      '#name' => '',
      '#suffix' => '</div></div>',
    ];
    return $form;
  }

  /**
   * Filtra los variables enviadas y de acuerdo a sus valores
   * personaliza la consulta a enviarse a la vista
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $titulo = $form_state->getValue('field_titulo_value');
    $inicio = $form_state->getValue('field_fecha_inicio_value');
    $fin = $form_state->getValue('field_fecha_fin_value');
    $query = [];
    if (strlen($titulo)>0) {
      $query = array_merge($query, ['title' => $titulo]);
      $query = array_merge($query, ['title_op' => 'contains']);
    }

    if (strlen($inicio)>0) {
      $query = array_merge($query, ['field_fecha_de_publicacion_value_1' => $inicio]);
    }
    if (strlen($fin)>0) {
      $query = array_merge($query, ['field_fecha_de_publicacion_value' => $fin.' 23:59:59']);
    }


    $response = new RedirectResponse(\Drupal::url('filternews.search', array() , array('query' => $query)));
    $response->send();

    return;
  }

}
