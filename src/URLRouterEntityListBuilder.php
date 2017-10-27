<?php
/**
 * @file
 * Contains Drupal\urlrouter\URLRouterEntityListBuilder.php.
 */

namespace Drupal\urlrouter;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of URL Router entities.
 */
class URLRouterEntityListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['source'] = $this->t('Source');
    $header['destination'] = $this->t('Destination');
    $header['permanent'] = $this->t('Permanent');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['source'] = $entity->getSource();
    $row['destination'] = $entity->getDestination();
    $row['permanent'] = $entity->getPermanent() ? 'Yes' : 'No';

    return $row + parent::buildRow($entity);
  }

}
