<?php

class Bacon_Ipsum_REST_API {

	static public function plugins_loaded() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_endpoint' ) );

		add_filter ( 'rest_pre_serve_request', array( __CLASS__, 'maybe_return_text' ), 10, 4 );

	}

	static public function register_endpoint() {

		$args = array(
			'number-of-paragraphs' => array(
				'default'   => 1,
				'sanitize_callback' => 'absint',
				),
			'format' => array(
				'sanitize_callback' => 'sanitize_key',
				'default' => 'json',
				),
			);

		register_rest_route(
			'baconipsum',
			"/v1/generate",
			array(
				'methods'    => WP_REST_Server::READABLE,
				'callback'   => array( __CLASS__, 'generate_filler' ),
				'args'       => $args,
				)
			);

	}

	static public function generate_filler( $request ) {

		$response = new stdClass();

		$filler = apply_filters( 'anyipsum-generate-filler', array(
			'number-of-paragraphs'   => $request['number-of-paragraphs'],
			)
		);

		if ( 'slack' === $request['format'] ) {
			$response->response_type = 'in_channel';
			$response->text = implode( "\n\n", $filler );
		} else {
			$response->filler = $filler;
		}

		return rest_ensure_response( $response );
	}


	static public function validate_slack_token( $token ) {
		return $token === get_option( 'bacon-ipsum-rest-api-slack-token' );
	}

	static public function maybe_return_text( $served, $response, $request, $server ) {
		if ( 'text' === $request['format'] ) {
			header( 'Content-Type: text/plain' );
			echo implode( "\n\n", $response->data->filler );
			exit;
		}
	}


}
