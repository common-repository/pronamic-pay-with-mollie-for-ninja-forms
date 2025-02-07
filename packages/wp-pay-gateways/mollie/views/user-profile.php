<?php
/**
 * User profile.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 *
 * @since 1.1.6
 * @link  https://github.com/WordPress/WordPress/blob/4.5.2/wp-admin/user-edit.php#L578-L600
 */

namespace Pronamic\WordPress\Pay\Gateways\Mollie;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $user ) ) {
	return;
}

$customer_query = new CustomerQuery(
	[
		'user_id' => $user->ID,
	]
);

$customers = $customer_query->get_customers();

if ( empty( $customers ) ) {
	return;
}

?>
<h2><?php esc_html_e( 'Mollie', 'pronamic-pay-with-mollie-for-ninja-forms' ); ?></h2>

<style type="text/css">
	.form-table .pronamic-pay-mollie-customers-table th,
	.form-table .pronamic-pay-mollie-customers-table td {
		padding: 8px 10px;
	}
</style>

<table class="form-table" id="fieldset-billing">
	<tbody>
		<tr>
			<th>
				<?php echo esc_html( _x( 'Customers', 'mollie', 'pronamic-pay-with-mollie-for-ninja-forms' ) ); ?>
			</th>
			<td>
				<table class="widefat striped pronamic-pay-mollie-customers-table">
					<thead>
						<tr>
							<th scope="col"><?php \esc_html_e( 'ID', 'pronamic-pay-with-mollie-for-ninja-forms' ); ?></th>
							<th scope="col"><?php \esc_html_e( 'Test', 'pronamic-pay-with-mollie-for-ninja-forms' ); ?></th>
							<th scope="col"><?php \esc_html_e( 'Name', 'pronamic-pay-with-mollie-for-ninja-forms' ); ?></th>
							<th scope="col"><?php \esc_html_e( 'Email', 'pronamic-pay-with-mollie-for-ninja-forms' ); ?></th>
						</tr>
					</thead>

					<tbody>

						<?php foreach ( $customers as $customer ) : ?>

							<tr>
								<td>
									<?php

									$url = \add_query_arg(
										[
											'page' => 'pronamic_pay_mollie_customers',
											'id'   => $customer->mollie_id,
										],
										\admin_url( 'admin.php' )
									);

									\printf(
										'<a href="%s"><code>%s</code></a>',
										\esc_url( $url ),
										\esc_html( $customer->mollie_id )
									);

									?>
								</td>
								<td>
									<?php $customer->test_mode ? \esc_html_e( 'Yes', 'pronamic-pay-with-mollie-for-ninja-forms' ) : \esc_html_e( 'No', 'pronamic-pay-with-mollie-for-ninja-forms' ); ?>
								</td>
								<td>
									<?php echo empty( $customer->name ) ? '—' : \esc_html( $customer->name ); ?>
								</td>
								<td>
									<?php

									echo empty( $customer->email ) ? esc_html( '—' ) : \sprintf(
										'<a href="%s">%s</a>',
										esc_attr( 'mailto:' . $customer->email ),
										esc_html( $customer->email )
									);

									?>
								</td>
							</tr>

						<?php endforeach; ?>

					</tbody>
				</table>

				<p class="description">
					<?php

					esc_html_e( 'Mollie offers the possibility to register payers as a customer within the Mollie payment platform. This functionality remembers payment preferences to make future payments easier. The Mollie customers can be linked to WordPress users. This is a list of Mollie customers associated with this WordPress user. For subscriptions, a Mollie customer mandate can be used for recurring payments.', 'pronamic-pay-with-mollie-for-ninja-forms' );

					?>
				</p>
			</td>
		</tr>
	</tbody>
</table>
