<?php

/**
 * Extension class with basic extension information. This class serves as static
 * class with the static parser functions but also as variables store instance
 * as object assigned to a Parser object.
 */
class ExtLocalVariables {

	private static $mVarStorage = [];

	/**
	 * Implements #lvardef parser function to save variable values.
	 *
	 * @param Parser  $parser The MediaWiki Parser instance
	 * @param PPFrame $frame  The MediaWiki PPFrame instance
	 * @param array   $args   The arguments to the parser function
	 *
	 * @return string '' This parser function has no output.
	 */
	public static function pf_lvardef( Parser $parser, PPFrame $frame, array $args ) {
		$varName = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		$value = isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';

		$fid = spl_object_id( $frame );
		self::$mVarStorage[ $fid ][ $varName ] = $value;

		return '';
	}

	/**
	 * Implements #lvar parser function to return the value of a variable.
	 *
	 * @param Parser  $parser The MediaWiki Parser instance
	 * @param PPFrame $frame  The MediaWiki PPFrame instance
	 * @param array   $args   The arguments to the parser function
	 *
	 * @return string Value assigned to the variable or empty string if undefined.
	 */
	public static function pf_lvar( Parser $parser, PPFrame $frame, array $args ) {
		$varName = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';

		$fid = spl_object_id( $frame );
		$value = self::$mVarStorage[ $fid ][ $varName ] ?? '';

		// Only expand argument when needed.
		if ( $value === '' && isset( $args[1] ) ) {
			return trim( $frame->expand( $args[1] ) );
		}

		return $value;
	}

}
