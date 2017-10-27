<?php

/**
 * @file
 * Drupal\urlrouter\Entity\URLRouterEntityInterface.
 */

namespace Drupal\urlrouter\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining URL Router entities.
 */
interface URLRouterEntityInterface extends ConfigEntityInterface {

  /**
   * Gets the entity ID.
   *
   * @return string
   */
  public function getId();

  /**
   * Sets the entity key.
   *
   * This can only be used before the entity is initially
   * saved. The value should be the source URL in plain text, we do not care if
   * the value contains illegal characters as we're going to sanitise it before
   * saving to the database.
   *
   * @param string $id
   *
   * @return \Drupal\urlrouter\Entity\URLRouterEntity
   */
  public function setId($id);

  /**
   * Gets the source URL. You can use $entity->label() also.
   *
   * @return string
   */
  public function getSource();

  /**
   * Sets the source URL.
   *
   * @param string $source
   *
   * @return \Drupal\urlrouter\Entity\URLRouterEntity
   */
  public function setSource($source);

  /**
   * Gets the destination URL.
   *
   * @return string
   */
  public function getDestination();

  /**
   * Sets the destination URL.
   *
   * @param string $destination
   *
   * @return \Drupal\urlrouter\Entity\URLRouterEntity
   */
  public function setDestination($destination);

  /**
   * If the redirect is permanent or not.
   *
   * Returns true or false depending on whether the URL has been setup to use
   * 301 or 302 redirects.
   *
   * @return bool
   */
  public function getPermanent();

  /**
   * Set whether the redirect should be 301 or 302.
   *
   * TRUE  - 301
   * FALSE - 302
   *
   * @param bool $permanent
   *
   * @return \Drupal\urlrouter\Entity\URLRouterEntity
   */
  public function setPermanent($permanent);

  /**
   * Gets the status code for the current URL router entity.
   *
   * @return int
   */
  public function getStatusCode();

}
