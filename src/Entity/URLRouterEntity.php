<?php

/**
 * @file
 * Drupal\Core\Config\Entity\ConfigEntityBase\URLRouterEntity.
 */

namespace Drupal\urlrouter\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the URL Router entity.
 *
 * @ConfigEntityType(
 *   id = "urlrouter_entity",
 *   label = @Translation("URL Router"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\urlrouter\URLRouterEntityListBuilder",
 *     "form" = {
 *       "add" = "Drupal\urlrouter\Form\URLRouterEntityForm",
 *       "edit" = "Drupal\urlrouter\Form\URLRouterEntityForm",
 *       "delete" = "Drupal\urlrouter\Form\URLRouterEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "urlrouter_entity",
 *   admin_permission = "administer url router",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "source",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/config/search/urlrouter_entity/{urlrouter_entity}",
 *     "add-form" = "/admin/config/search/urlrouter_entity/add",
 *     "edit-form" = "/admin/config/search/urlrouter_entity/{urlrouter_entity}/edit",
 *     "delete-form" = "/admin/config/search/urlrouter_entity/{urlrouter_entity}/delete",
 *     "collection" = "/admin/config/search/urlrouter_entity"
 *   }
 * )
 */
class URLRouterEntity extends ConfigEntityBase implements URLRouterEntityInterface {

  /**
   * The URL Router ID.
   *
   * @var string
   */
  protected $id;

  /**
   * @var string
   */
  protected $source;

  /**
   * @var string
   */
  protected $destination;

  /**
   * @var boolean
   */
  protected $permanent;

  /**
   * {@inheritdoc}
   */
  public static function load($id) {
    $encoded_id = self::encode($id);
    return parent::load($encoded_id);
  }

  /**
   * Encode the string so we can use special characters.
   */
  private static function encode($id) {
    return md5($id);
  }

  /**
   * Gets the redirect status code.
   *
   * Determines whether we should use 301 or 302 status code when redirecting
   * the user.
   *
   * @return int
   */
  public function getStatusCode() {
    return $this->getPermanent() ? 301 : 302;
  }

  /**
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param $id
   *
   * @return $this
   */
  public function setId($id) {
    $this->id = self::encode($id);
    return $this;
  }

  /**
   * @return string
   */
  public function getSource() {
    return $this->source;
  }

  /**
   * @param $source
   *
   * @return $this
   */
  public function setSource($source) {
    $this->source = $source;
    return $this;
  }

  /**
   * @return string
   */
  public function getDestination() {
    return $this->destination;
  }

  /**
   * @param $destination
   *
   * @return $this
   */
  public function setDestination($destination) {
    $this->destination = $destination;
    return $this;
  }

  /**
   * @return string
   */
  public function getPermanent() {
    return $this->permanent;
  }

  /**
   * @param $permanent
   *
   * @return $this
   */
  public function setPermanent($permanent) {
    $this->permanent = $permanent;
    return $this;
  }

}
