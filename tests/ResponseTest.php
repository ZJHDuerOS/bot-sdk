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
 * @desc Response类的测试类
 */
class ResponseTest extends PHPUnit_Framework_TestCase{
	
	/**
     * @before
     */
    public function setupSomeFixtures()
    {
        $this->data = json_decode(file_get_contents(dirname(__FILE__).'/intent_request.json'), true);
        $this->request = new Baidu\Duer\Botsdk\Request($this->data);
        $this->session = $this->request->getSession();
        $this->nlu = $this->request->getNlu();
        $this->response = new Baidu\Duer\Botsdk\Response($this->request, $this->session, $this->nlu);	
    }	

	/**
     * @desc 测试setShouldEndSession方法
     */
	function testSetShouldEndSession(){
		$this->response->setShouldEndSession(false);
		$ret = [];
		$json = $this->response->build($ret);
		$shouldEndSession = json_decode($json, true)['response']['shouldEndSession'];
		$this->assertFalse($shouldEndSession);
	}

	/**
	 * @desc 测试defaultResult方法
	 */
	function testDefaultResult(){
		$this->assertEquals($this->response->defaultResult(), '{"status":0,"msg":null}');
	}

	/**
     * @desc 测试build方法
     */
	function testBuild(){
		$this->response->setShouldEndSession(false);
		$card = new \Baidu\Duer\Botsdk\Card\TextCard("测试服务");
		$ret = [
			'card' => $card,
			'outputSpeech' => '测试服务，欢迎光临',
		];
		$json = $this->response->build($ret);
		$rt = '{"version":"2.0","context":{"updateIntent":{"intent":{"name":"intentName","score":100,"confirmationStatus":"NONE","slots":{"city":{"name":"city","value":"北京","score":0,"confirmationStatus":"NONE"}}}}},"session":{"attributes":{}},"response":{"directives":[],"shouldEndSession":false,"card":{"type":"txt","content":"测试服务"},"resource":null,"outputSpeech":{"type":"PlainText","text":"测试服务，欢迎光临"},"reprompt":null}}';
		$this->assertEquals($json, $rt);
	}

	/**
     * @desc 测试formatSpeech方法
     */
	function testFormatSpeech(){
		$outputSpeech = '测试服务，欢迎光临';
		$rt = [
			'type' => 'PlainText',
			'text' => '测试服务，欢迎光临'
		];
		$formatSpeech = $this->response->formatSpeech($outputSpeech);
		$this->assertEquals($formatSpeech, $rt);
	}

}
