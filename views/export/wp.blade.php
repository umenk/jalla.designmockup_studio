@php
$default_author = 'Admin';
$site_url = 'http://example.com/';
//$backdate = isset($argv[1]) ? strtotime($argv[1]) : strtotime('-1 month');
$backdate 	= BACK_DATE;
$schedule 	= SHEDULE_DATE;
$wp_cat 	= WP_CATEGORY;
$category 	= isset($argv[2]) ? $argv[2] : $wp_cat;
@endphp
{!! '<' . '?' . "xml version='1.0' encoding='UTF-8'?>" !!}
<rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/1.0/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/1.0/"
>

<channel>
	<title>My Site</title>
	<link>http://example.com/</link>
	<description></description>
	<pubDate>Thu, 28 May 2009 16:06:40 +0000</pubDate>
	<wp:author><wp:author_id>1</wp:author_id><wp:author_login><![CDATA[admin]]></wp:author_login><wp:author_email><![CDATA[buchin@dropsugar.com]]></wp:author_email><wp:author_display_name><![CDATA[admin]]></wp:author_display_name><wp:author_first_name><![CDATA[]]></wp:author_first_name><wp:author_last_name><![CDATA[]]></wp:author_last_name></wp:author>
	
	<generator>http://wordpress.org/?v=2.7.1</generator>
	<language>en</language>
	<wp:wxr_version>1.0</wp:wxr_version>
	<wp:base_site_url>http://example.com/</wp:base_site_url>
	<wp:base_blog_url>http://example.com/</wp:base_blog_url>

	@foreach($keywords as $post_id => $keyword)
		@php
			$data 			 	= get_data(new_slug($keyword));
			$keyword 		 	= $data['images'][0]['keyword'];
			$data['keyword'] 	= $keyword;
			
			$slug 				= new_slug($keyword);
			$post_date 			=  date("Y-m-d\TH:i:s\Z", rand(strtotime($backdate), strtotime($schedule)));
			if(empty($data['images'])){ continue; }
			$post_content 		= export('export.post', $data);
			$post_content 		= Minify_Html($post_content);
			$thumbnail_id 		= 1000000+$post_id;
			$thumb 		  		= $data['images'][0];
			$thumbnail_url 		= $thumb['url'];
			$thumbnail_ext 		= $thumb['filetype'];
			$arr_tags 			= explode('-',new_slug($keyword, '-', FALSE, FALSE));
		@endphp
		<item>
			<title><![CDATA[{{ ucwords($keyword) }}]]></title>
			
			<link>{{ $site_url }}{{ $slug }}/</link>
			<pubDate>{{ date("Y-m-d\TH:i:s\Z") }}</pubDate>

			<dc:creator><![CDATA[{{ $default_author }}]]></dc:creator>
			<wp:postmeta>
				<wp:meta_key>_byline</wp:meta_key>
				<wp:meta_value>{{ $default_author }}</wp:meta_value>
			</wp:postmeta>

			@php
			$category = trim( $category );
			$cat_slug = new_slug( $category );
			@endphp

			<category><![CDATA[{{ $category }}]]></category>
			<category domain="category" nicename="{{ $cat_slug }}"><![CDATA[{{ $category }}]]></category>

			@foreach ( collect($arr_tags)->shuffle()->take(4) as $tag )
			@if(strlen($tag) <= 3) 
			    @continue
			@endif
				<category domain="tag" nicename="{{ new_slug( $tag ) }}"><![CDATA[{{ $tag }}]]></category>
			@endforeach			
		
			<guid isPermaLink="false">{{ $site_url }}?p={{ $post_id }}</guid>
			<description></description>
			<content:encoded><![CDATA[{!! $post_content !!}]]></content:encoded>
			<excerpt:encoded><![CDATA[]]></excerpt:encoded>
			<wp:post_id>{{ $post_id }}</wp:post_id>
			<wp:post_date_gmt>{{ $post_date }}</wp:post_date_gmt>
			<wp:comment_status>open</wp:comment_status>
			<wp:ping_status>closed</wp:ping_status>
			<wp:post_name>{{ $slug }}</wp:post_name>

			<wp:status>publish</wp:status>
			<wp:post_parent>0</wp:post_parent>
			<wp:menu_order>0</wp:menu_order>
			<wp:post_type>post</wp:post_type>
			<wp:post_password></wp:post_password>
			
			<wp:postmeta>
				<wp:meta_key>_old_id</wp:meta_key>
				<wp:meta_value>{{ $post_id }}</wp:meta_value>
			</wp:postmeta>

			<wp:postmeta>
				<wp:meta_key><![CDATA[json_ld]]></wp:meta_key> 
				<wp:meta_value><![CDATA[<script type="application/ld+json">
				{
				  "@context": "https://schema.org/", 
				  "@type": "Article", 
				  "author": {
				    "@type": "Person",
				    "name": "Admin"
				  },
				  "headline": "{{ ucwords($keyword) }}",
				  "datePublished": "{{ date('Y-m-d') }}",
				  "image": "{{ $thumbnail_url }}",
				  "publisher": {
				    "@type": "Organization",
				    "name": "{{ SITE_NAME }}",
				    "logo": {
				      "@type": "ImageObject",
				      "url": "https://via.placeholder.com/512.png?text={{ rawurlencode(convert_accented_characters($keyword)) }}",
				      "width": 512,
				      "height": 512
				    }
				  }
				}
				</script>]]></wp:meta_value>
			</wp:postmeta>

			<wp:postmeta>
				<wp:meta_key><![CDATA[_thumbnail_id]]></wp:meta_key>
				<wp:meta_value><![CDATA[{{ $thumbnail_id }}]]></wp:meta_value>
			</wp:postmeta>

		</item>
		
		<item>
			<title><![CDATA[{{ ucwords($keyword) }}]]></title>
			<link>{{ $site_url }}?attachment_id={{ $thumbnail_id }}</link>
			<pubDate>Sun, 27 Sep 2020 19:49:11 +0000</pubDate>
			<dc:creator><![CDATA[admin]]></dc:creator>
			<guid isPermaLink="false">{{ $thumbnail_url }}</guid>
			<description></description>
			<content:encoded><![CDATA[]]></content:encoded>
			<excerpt:encoded><![CDATA[]]></excerpt:encoded>
			<wp:post_id>{{ $thumbnail_id }}</wp:post_id>
			<wp:post_date><![CDATA[{{ $post_date }}]]></wp:post_date>
			<wp:post_date_gmt><![CDATA[{{ $post_date }}]]></wp:post_date_gmt>
			<wp:comment_status><![CDATA[open]]></wp:comment_status>
			<wp:ping_status><![CDATA[closed]]></wp:ping_status>
			<wp:post_name><![CDATA[{{ $keyword }}]]></wp:post_name>
			<wp:status><![CDATA[inherit]]></wp:status>
			<wp:post_parent>{{ $post_id }}</wp:post_parent>
			<wp:menu_order>0</wp:menu_order>
			<wp:post_type><![CDATA[attachment]]></wp:post_type>
			<wp:post_password><![CDATA[]]></wp:post_password>
			<wp:is_sticky>0</wp:is_sticky>
			<wp:attachment_url><![CDATA[{{ $thumbnail_url }}]]></wp:attachment_url>
			<wp:postmeta>
			<wp:meta_key><![CDATA[_wp_attached_file]]></wp:meta_key>
			<wp:meta_value><![CDATA[{{ date("Y/m") }}/{{ $slug }}.{{ $thumbnail_ext }}]]></wp:meta_value>
			</wp:postmeta>
		</item>
	@endforeach

</channel>
</rss>
