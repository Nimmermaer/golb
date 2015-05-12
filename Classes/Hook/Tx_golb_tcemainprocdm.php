<?php
namespace Blog\Golb\Hook;
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 16.03.2015
 * Time: 13:09
 */


class Tx_golb_tcemainprocdm {

	function processDatamap_preProcessFieldArray( &$fieldArray, $table, $id, &$pObj ) {

	  if ( $_POST['data'][ $table ][ $id ]['golb_tags_hidden'][1] != '' ) {
			$editTags = array();

			if ( $_POST['data'][ $table ][ $id ]['golb_tags_hidden'] ) {
				foreach ( $_POST['data'][ $table ][ $id ]['golb_tags_hidden'] as $tag ) {
					if ( trim( strlen( $tag ) ) > 0 ) {
						$editTags[] = $tag;
					}
				}

				$allTags = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'tx_golb_domain_model_tag.title, tx_golb_domain_model_tag.uid',
					'tx_golb_domain_model_tag',
					'deleted = 0',
					'',
					'',
					'',
					'title'
				);

				foreach ( $editTags as $tag ) {
					if ( ! array_key_exists( $tag, $allTags ) ) {
						$GLOBALS['TYPO3_DB']->exec_INSERTquery(
							'tx_golb_domain_model_tag',
							array(
								'pid'   => intval( $id ),
								'title' => $tag,
							)

						);
						$tagsToUpdate[] = $GLOBALS['TYPO3_DB']->sql_insert_id();
					} else {

						$tagsToUpdate[] = $allTags[ $tag ]['uid'];
					}
				}

				$fieldArray['golb_tags'] = implode( ',', $tagsToUpdate );
			}
		}
		}

}

