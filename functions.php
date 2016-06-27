function export_posts_as_csv() {

	$args = array(
        'posts_per_page'    => -1,
        'post_type'         => 'pages',
        'post_status'       => array( 'publish', 'pending' ),
        'orderby'           => 'title',
        'order'             => 'ASC'
    );
    query_posts( $args );

    header( 'Content-Type: text/csv' );
    header( 'Content-Disposition: attachment;filename=my_pages.csv');
    
    $output = fopen( 'php://output', 'w' );
    fputcsv( $output, array( 'Nr', 'Page_ID', 'Page_Title', 'Page_Status' ) );
    
    $i = 1;
    while( have_posts() ) : the_post();
        
		fputcsv( $output, array( $i, get_the_ID(), get_the_title(), get_post_status() ) );
		$i++;

    endwhile;
    wp_reset_query();

    fclose( $output );
    die;
}
