<?php
/**
 * JSON-LD Schema.org for SEO + AEO (Organization, WebSite, FAQ, Service).
 *
 * @package Apexora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'wp_head',
	function () {
		if ( function_exists( 'apexora_flag' ) && ! apexora_flag( 'ENABLE_JSON_LD', true ) ) {
			return;
		}

		$org_name = apexora_org_name();
		$email    = function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_EMAIL', 'hello@apexora.id' ) : 'hello@apexora.id';
		$phone    = function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_PHONE', '+62-21-5550-1200' ) : '+62-21-5550-1200';
		$address  = function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_ADDRESS', 'Jakarta, Indonesia' ) : 'Jakarta, Indonesia';

		$graphs = array();

		$graphs[] = array(
			'@type'       => 'Organization',
			'@id'         => home_url( '/#organization' ),
			'name'        => $org_name,
			'url'         => home_url( '/' ),
			'email'       => $email,
			'telephone'   => $phone,
			'description' => $org_name . ' adalah software house untuk produk digital, web, mobile, dan enterprise systems.',
			'address'     => array(
				'@type'         => 'PostalAddress',
				'addressLocality' => $address,
				'addressCountry'  => 'ID',
			),
			'sameAs'      => array(),
		);

		$graphs[] = array(
			'@type'           => 'WebSite',
			'@id'             => home_url( '/#website' ),
			'url'             => home_url( '/' ),
			'name'            => $org_name,
			'publisher'       => array( '@id' => home_url( '/#organization' ) ),
			'inLanguage'      => 'id-ID',
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => home_url( '/?s={search_term_string}' ),
				'query-input' => 'required name=search_term_string',
			),
		);

		if ( is_page( 'produk-servis' ) || is_front_page() ) {
			$services = array(
				'Custom Software Development',
				'Product Discovery & MVP',
				'UI/UX Design',
				'Cloud & DevOps',
				'Mobile App Development',
				'Maintenance & Support',
			);
			foreach ( $services as $svc ) {
				$graphs[] = array(
					'@type'       => 'Service',
					'name'        => $svc,
					'provider'    => array( '@id' => home_url( '/#organization' ) ),
					'areaServed'  => 'ID',
					'url'         => home_url( '/produk-servis/' ),
				);
			}
		}

		if ( is_page( 'faq' ) || is_front_page() ) {
			$faq_entities = array();
			foreach ( apexora_answer_bank() as $item ) {
				$faq_entities[] = array(
					'@type'          => 'Question',
					'name'           => $item['q'],
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => $item['a'],
					),
				);
			}
			$graphs[] = array(
				'@type'      => 'FAQPage',
				'@id'        => home_url( '/faq/#faq' ),
				'mainEntity' => $faq_entities,
			);
		}

		if ( is_page( 'events' ) ) {
			$graphs[] = array(
				'@type'       => 'Event',
				'name'        => 'Apexora Tech Meetup',
				'startDate'   => '2026-08-20T18:00:00+07:00',
				'eventStatus' => 'https://schema.org/EventScheduled',
				'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
				'location'    => array(
					'@type'   => 'Place',
					'name'    => 'Jakarta',
					'address' => $address,
				),
				'organizer'   => array( '@id' => home_url( '/#organization' ) ),
				'description' => 'Meetup teknologi untuk developer dan product teams.',
			);
		}

		if ( is_singular( 'post' ) ) {
			$post = get_queried_object();
			if ( $post instanceof WP_Post ) {
				$article = array(
					'@type'            => 'Article',
					'@id'              => get_permalink( $post ) . '#article',
					'headline'         => get_the_title( $post ),
					'datePublished'    => get_the_date( DATE_W3C, $post ),
					'dateModified'     => get_the_modified_date( DATE_W3C, $post ),
					'author'           => array(
						'@type' => 'Person',
						'name'  => get_the_author_meta( 'display_name', (int) $post->post_author ),
					),
					'publisher'        => array( '@id' => home_url( '/#organization' ) ),
					'mainEntityOfPage' => get_permalink( $post ),
					'inLanguage'       => 'id-ID',
					'description'      => wp_trim_words( wp_strip_all_tags( $post->post_excerpt ?: $post->post_content ), 30 ),
				);
				if ( has_post_thumbnail( $post ) ) {
					$article['image'] = get_the_post_thumbnail_url( $post, 'full' );
				}
				$graphs[] = $article;
			}
		}

		if ( is_home() && ! is_front_page() ) {
			$graphs[] = array(
				'@type'       => 'Blog',
				'@id'         => home_url( '/blog/#blog' ),
				'name'        => 'Blog ' . $org_name,
				'url'         => function_exists( 'apexora_blog_url' ) ? apexora_blog_url() : home_url( '/blog/' ),
				'publisher'   => array( '@id' => home_url( '/#organization' ) ),
				'description' => 'Artikel engineering dan product dari ' . $org_name,
			);
		}

		$payload = array(
			'@context' => 'https://schema.org',
			'@graph'   => $graphs,
		);

		echo '<script type="application/ld+json">' . wp_json_encode( $payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	},
	20
);
