<script type="application/ld+json">
{
  "@context": "https://schema.org/", 
  "@type": "Article", 
  "author": {
    "@type": "Person",
    "name": "{{ SITE_AUTHOR }}"
  },
  "headline": "{{ ucwords($keyword) }}",
  "datePublished": "{{ date('Y-m-d') }}",
  "image": "{{ collect($images)->random()['url'] }}",
  "publisher": {
    "@type": "Organization",
    "name": "{{ SITE_NAME }}",
    "logo": {
      "@type": "ImageObject",
      "url": "https://via.placeholder.com/512.png?text={{ urlencode($keyword) }}",
      "width": 512,
      "height": 512
    }
  }
}
</script>
