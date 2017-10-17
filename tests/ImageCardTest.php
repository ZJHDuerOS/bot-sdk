<?php

ini_set("display_errors", "On");
ini_set('track_errors', true);
ini_set('error_reporting', E_ALL & ~E_NOTICE);

require '../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

/**
 * Copyright (c) 2017 Baidu, Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @desc ImageCard类的测试类
 */
class ImageCardTest extends PHPUnit_Framework_TestCase{
	
	/**
     * @before
     */
    public function setupSomeFixtures()
    {
		$this->card = new Baidu\Duer\Botsdk\Card\ImageCard();
    }
	
	/**
     * @desc 测试addItem方法
     */
	function testAddItem(){
		$this->card->addItem('www.png');	
		$card = [
			'type' => 'image',
			'list' =>  [['src' => 'www.png']]
		];
		$this->assertEquals($this->card->getData(), $card);

		$this->card->addItem('www.png','www.thumbnail');	
		$card = [
			'type' => 'image',
			'list' =>  [['src' => 'www.png'],['src' => 'www.png', 'thumbnail' => 'www.thumbnail']]
		];
		$this->assertEquals($this->card->getData(), $card);
	}

}
