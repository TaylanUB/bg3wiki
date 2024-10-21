<?php

/**
 * Extension class containing the hook functions called by core to incorporate the
 * functionality of the LocalVariables extension.
 */
class LocalVariablesHooks {

	/**
	 * Sets up parser functions
	 *
	 * @since 1.4
	 *
	 * @param Parser $parser
	 */
	public static function onParserFirstCallInit( Parser $parser ) {
		self::initFunction( $parser, 'lvar' );
		self::initFunction( $parser, 'lvardef' );
	}

	/**
	 * Does the actual setup after making sure the functions aren't disabled
	 *
	 * @param Parser $parser
	 * @param string $name The name of the parser function
	 */
	private static function initFunction( Parser $parser, $name ) {
		$parser->setFunctionHook(
			$name,
			[ ExtLocalVariables::class, "pf_$name" ],
			Parser::SFH_OBJECT_ARGS
		);
	}

}
