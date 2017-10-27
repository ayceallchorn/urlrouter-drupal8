<?php

/**
 * @file
 * Contains Drupal\urlrouter\Form\URLRouterEntityForm.
 */

namespace Drupal\urlrouter\Form;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class URLRouterEntityForm.
 */
class URLRouterEntityForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /** @var \Drupal\urlrouter\Entity\URLRouterEntityInterface $urlrouter_entity */
    $urlrouter_entity = $this->entity;

    $form['urlredirect_source'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Source'),
      '#description' => $this->t('Enter the full URL beginning with http:// or https://.'),
      '#maxlength' => 255,
      '#default_value' => $urlrouter_entity->label(),
      '#disabled' => !$urlrouter_entity->isNew(),
      '#required' => TRUE,
    ];

    // This cannot be set to 'destination' due to conflicts with the core config
    // entity. I have changed both to 'urlredirect_' for consistency.
    $form['urlredirect_destination'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Destination'),
      '#description' => $this->t('Enter the full URL beginning with http:// or https://.'),
      '#maxlength' => 255,
      '#default_value' => $urlrouter_entity->getDestination(),
      '#required' => TRUE,
    ];

    $form['urlredirect_permanent'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Permanent (301)'),
      '#default_value' => $urlrouter_entity->getPermanent(),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!UrlHelper::isValid($form_state->getValue('urlredirect_source'), TRUE)) {
      $form_state->setErrorByName('urlrouter_source', $this->t('URL must be valid'));
    }

    if (!UrlHelper::isValid($form_state->getValue('urlredirect_destination'), TRUE)) {
      $form_state->setErrorByName('urlredirect_destination', $this->t('URL must be valid'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\urlrouter\Entity\URLRouterEntityInterface $urlrouter_entity */
    $urlrouter_entity = $this->entity;

    // Add fields to entity storage.
    $urlrouter_entity->setSource($form_state->getValue('urlredirect_source'));
    $urlrouter_entity->setDestination($form_state->getValue('urlredirect_destination'));
    $urlrouter_entity->setPermanent($form_state->getValue('urlredirect_permanent'));

    // Set the ID if this is a new entity.
    if ($urlrouter_entity->isNew()) {
      $urlrouter_entity->setId($urlrouter_entity->getSource());
    }

    $status = $urlrouter_entity->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label URL Router.', [
          '%label' => $urlrouter_entity->getSource(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label URL Router.', [
          '%label' => $urlrouter_entity->getSource(),
        ]));
    }
    $form_state->setRedirectUrl($urlrouter_entity->toUrl('collection'));
  }

}
