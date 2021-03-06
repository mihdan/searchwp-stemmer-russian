<?php
/**
 * Plugin Name: Mihdan: SearchWP Russian Stemmer
 * Plugin URI: https://github.com/mihdan/mihdan-searchwp-stemmer-russian
 * Description: Russian keyword stemming
 * Version: 1.0.2
 * Author: Mikhail Kobzarev
 * Author URI: https://www.kobzarev.com/
 *
 * Copyright 2016 Mikhail Kobzarev
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 * TODO: попробовать http://phpmorphy.sourceforge.net/dokuwiki/manual
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SEARCHWP_STEMMER_RUSSIAN_VERSION' ) ) {
	define( 'SEARCHWP_STEMMER_RUSSIAN_VERSION', '1.0.2' );
}

if ( ! class_exists( 'SearchWP_Russian_Stemmer' ) ) {
	include_once( dirname( __FILE__ ) . '/vendor/class.russian-stemmer.php' );
}

/**
 * Class SearchWP_Russian_Stemmer_Wrapper
 */
class SearchWP_Russian_Stemmer_Wrapper {

	/**
	 * SearchWP_Russian_Stemmer_Wrapper constructor.
	 */
	function __construct() {

		// tell SearchWP we have a stemmer
		add_filter( 'searchwp_keyword_stem_locale', '__return_true' );

		// add our custom stemmer
		add_filter( 'searchwp_custom_stemmer', array( $this, 'russian_stemmer' ) );

		// добавить свои стоп слова
		add_filter( 'searchwp_stopwords', array( $this, 'russian_common_words' ) );

	}

	/**
	 * Common words
	 *
	 * @link http://snowball.tartarus.org/algorithms/russian/stop.txt
	 *
	 * @param $terms
	 *
	 * @return array
	 */
	function russian_common_words( $terms ) {
		// Computes the difference of arrays
		$diff = array_diff(
			$terms,
			array(
				'не',
				'я',
				'и',
				'в',
				'что',
				'на',
				'а',
				'то',
				'с',
				'но',
				'как',
				'все',
				'бы',
				'у',
				'это',
				'так',
				'по',
				'мне',
				'если',
				'еще',
				'к',
				'вот',
				'было',
				'за',
				'же',
				'там',
				'будет',
				'уже',
				'он',
				'ты',
				'ее',
				'только',
				'она',
				'из',
				'от',
				'даже',
				'хотя',
				'до',
				'его',
				'нет',
				'да',
				'о',
				'есть',
				'ну',
				'нибудь',
				'для',
				'чем',
				'про',
				'ни',
				'их',
				'ли',
				'они',
				'или',
				'был',
				'мы',
				'раз',
				'тут',
				'во',
				'кто',
				'ней',
				'где',
				'нее',
				'них',
				'том',
				'со',
				'нас',
				'вы',
				'уж',
				'ей',
				'тот',
				'без',
				'более',
				'больше',
				'большой',
				'был',
				'была',
				'были',
				'было',
				'быть',
				'вам',
				'вас',
				'вдоль',
				'ведь',
				'весь',
				'видно',
				'вместо',
				'вне',
				'вниз',
				'внизу',
				'внутри',
				'вокруг',
				'восемь',
				'вот',
				'все',
				'всегда',
				'всего',
				'всей',
				'всех',
				'всё',
				'вся',
				'где',
				'говорил',
				'говорили',
				'говорим',
				'говорить',
				'говорят',
				'год',
				'давай',
				'давать',
				'давно',
				'даже',
				'далеко',
				'два',
				'девять',
				'день',
				'десять',
				'для',
				'долго',
				'достаточно',
				'другого',
				'другой',
				'другое',
				'другие',
				'его',
				'если',
				'есть',
				'еще',
				'ещё',
				'зачем',
				'здесь',
				'знать',
				'ибо',
				'изо',
				'или',
				'именно',
				'иметь',
				'иной',
				'ином',
				'каждый',
				'каждого',
				'каждому',
				'каждым',
				'как',
				'какой',
				'какое',
				'когда',
				'который',
				'кроме',
				'кто',
				'либо',
				'лишь',
				'между',
				'меня',
				'мне',
				'много',
				'мог',
				'могу',
				'может',
				'мои',
				'мой',
				'навсегда',
				'над',
				'надо',
				'назад',
				'нам',
				'нас',
				'наш',
				'него',
				'недавно',
				'нее',
				'неё',
				'некто',
				'нельзя',
				'несколько',
				'нет',
				'никто',
				'них',
				'ноль',
				'оба',
				'обо',
				'один',
				'однако',
				'около',
				'она',
				'они',
				'оно',
				'оный',
				'опять',
				'особенно',
				'ото',
				'отчего',
				'очень',
				'под',
				'пожалуйста',
				'после',
				'потому',
				'похоже',
				'почему',
				'почти',
				'при',
				'про',
				'прямо',
				'пусть',
				'пять',
				'равно',
				'ребята',
				'редко',
				'сам',
				'самая',
				'сами',
				'самим',
				'самой',
				'самому',
				'самый',
				'самым',
				'самому',
				'свой',
				'себя',
				'семь',
				'сказал',
				'сказали',
				'сказать',
				'сначала',
				'снова',
				'совсем',
				'спасибо',
				'сразу',
				'среди',
				'стал',
				'стала',
				'стали',
				'стать',
				'ста',
				'сто',
				'так',
				'также',
				'такие',
				'такой',
				'там',
				'твой',
				'тем',
				'теперь',
				'тогда',
				'того',
				'тоже',
				'той',
				'только',
				'том',
				'тот',
				'точно',
				'три',
				'тут',
				'тысяч',
				'тысяча',
				'тысячи',
				'тысячу',
				'уже',
				'хотя',
				'хоть',
				'час',
				'часто',
				'часу',
				'чего',
				'чей',
				'чем',
				'четыре',
				'что',
				'чтоб',
				'чтобы',
				'чья',
				'чье',
				'чьё',
				'чья',
				'шесть',
				'эта',
				'эти',
				'это',
				'этого',
				'этом',
				'этот',
			)
		);

		// Compare arrays
		return array_merge( $terms, $diff );
	}

	/**
	 * @param $unstemmed
	 *
	 * @return string
	 */
	function russian_stemmer( $unstemmed ) {
		if ( ! class_exists( 'SearchWP_Russian_Stemmer' ) ) {
			return $unstemmed;
		}

		$stemmer = new SearchWP_Russian_Stemmer();

		$pre_processed = $stemmer->russianstemmer_search_preprocess( $unstemmed );
		$stemmed       = $stemmer->russianstemmer_stem( $pre_processed );

		return sanitize_text_field( $stemmed );
	}

}

new SearchWP_Russian_Stemmer_Wrapper();

// eof;
