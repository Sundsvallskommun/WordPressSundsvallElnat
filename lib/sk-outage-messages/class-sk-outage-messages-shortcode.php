<?php


class SK_Outage_Messages_Shortcode {

	public function __construct() {

		add_shortcode( 'outage_messages', [ $this, 'callback' ] );

	}


	public function callback( $atts = [] ) {
		$messages = SK_Outage_Messages::messages( true );
		if ( is_array( $messages ) && count( $messages ) > 0 ) {

			foreach( $messages as $message ) {
				?>
				<div class="card outage-message-card">
					<div class="card-block outage-message-card-block">
						<h4 class="card-title outage-message-title"><?php echo $message->meta['area'][0]; ?></h4>
						<?php if ( !empty( $message->post_content ) ) : ?>
							<p class="card-text outage-message-card-text"><span><?php echo $message->post_content; ?></span></p>
						<?php endif; ?>
						<p class="card-text outage-message-card-text">
							<?php _e( 'Avbrottet inträffade', 'sundsvallelnat' ); ?>: <span><?php echo $message->meta['starttime'][0]; ?></span>
						</p>
						<p class="card-text outage-message-card-text">
							<?php _e( 'Avbrottet åtgärdades', 'sundsvallelnat' ); ?>: <span><?php echo $message->meta['endtime'][0]; ?></span>
						</p>
					</div>
				</div>
				<?php
			}

		}

	}


}