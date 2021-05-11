<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke
 * @license   GPL-3.0-or-later
 *
 * The Chameleon skin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup Skins
 */

namespace Skins\Chameleon\Tests\Unit\Components;

use Skins\Chameleon\Tests\Util\MockupFactory;

/**
 * @coversDefaultClass \Skins\Chameleon\Components\PersonalTools
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
class PersonalToolsTest extends GenericComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\PersonalTools';

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_ShowNewtalkNotifier( $domElement ) {
		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();
		$chameleonTemplate->data = [ 'newtalk' => 'foo' ];

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );

		$this->assertTag( [ 'class' => 'usermessage' ], $instance->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_HideNewtalkNotifier( $domElement ) {
		$domElement->setAttribute( 'hideNewtalkNotifier', true );

		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();
		$chameleonTemplate->data = [ 'newtalk' => 'foo' ];

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );

		$this->assertNotTag( [ 'class' => 'usermessage' ], $instance->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_ShowEchoAsDefault( $domElement ) {
		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();
		$chameleonTemplate->expects( $this->exactly( 4 ) )
			->method( 'makeListItem' )
			->withConsecutive(
				[ 'foo', [ 'id' => 'pt-foo'], [ 'tag' => 'div', 'link-class' => 'pt-foo' ] ],
				[ 'bar', [ 'id' => 'pt-bar'], [ 'tag' => 'div', 'link-class' => 'pt-bar' ] ],
				// Icons are rendered without link-class
				[ 'notifications-alert', [ 'id' => 'pt-notifications-alert'],
					[ 'tag' => 'div' ] ],
				[ 'notifications-notice', [ 'id' => 'pt-notifications-notice'],
					[ 'tag' => 'div' ] ]
			);

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );
		$instance->getHtml();
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_ShowEchoAsIcons( $domElement ) {
		$domElement->setAttribute( 'showEchoAs', 'icons' );
		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();
		$chameleonTemplate->expects( $this->exactly( 4 ) )
			->method( 'makeListItem' )
			->withConsecutive(
				[ 'foo', [ 'id' => 'pt-foo'], [ 'tag' => 'div', 'link-class' => 'pt-foo' ] ],
				[ 'bar', [ 'id' => 'pt-bar'], [ 'tag' => 'div', 'link-class' => 'pt-bar' ] ],
				// Icons are rendered without link-class
				[ 'notifications-alert', [ 'id' => 'pt-notifications-alert'],
					[ 'tag' => 'div' ] ],
				[ 'notifications-notice', [ 'id' => 'pt-notifications-notice'],
					[ 'tag' => 'div' ] ]
			);

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );
		$instance->getHtml();
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_ShowEchoAsLinks( $domElement ) {
		$domElement->setAttribute( 'showEchoAs', 'links' );
		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();
		$chameleonTemplate->expects( $this->exactly( 4 ) )
			->method( 'makeListItem' )
			->withConsecutive(
				[ 'foo', [ 'id' => 'pt-foo'], [ 'tag' => 'div', 'link-class' => 'pt-foo' ] ],
				[ 'bar', [ 'id' => 'pt-bar'], [ 'tag' => 'div', 'link-class' => 'pt-bar' ] ],
				// Links are rendered with link-class
				[ 'notifications-alert', [ 'id' => 'pt-notifications-alert'],
					[ 'tag' => 'div', 'link-class' => 'pt-notifications-alert' ] ],
				[ 'notifications-notice', [ 'id' => 'pt-notifications-notice'],
					[ 'tag' => 'div', 'link-class' => 'pt-notifications-notice' ] ]
			);

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );
		$instance->getHtml();
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_ShowEchoAsHidden( $domElement ) {
		$domElement->setAttribute( 'showEchoAs', 'hidden' );
		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();
		$chameleonTemplate->expects( $this->exactly( 2 ) )
			->method( 'makeListItem' )
			->withConsecutive(
				[ 'foo', [ 'id' => 'pt-foo'], [ 'tag' => 'div', 'link-class' => 'pt-foo' ] ],
				[ 'bar', [ 'id' => 'pt-bar'], [ 'tag' => 'div', 'link-class' => 'pt-bar' ] ]
			);

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );
		$instance->getHtml();
	}
}
