<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach($items as $item)
    <url>
        <loc>{{ $item['loc'] }}</loc>
        @isset($item['lastmod'])<lastmod>{{ $item['lastmod'] }}</lastmod>@endisset
        @isset($item['changefreq'])<changefreq>{{ $item['changefreq'] }}</changefreq>@endisset
        @isset($item['priority'])<priority>{{ $item['priority'] }}</priority>@endisset
        @isset($item['image'])
            <image:image>
                <image:loc>{{ $item['image'] }}</image:loc>
                @isset($item['image_title'])<image:title>{{ $item['image_title'] }}</image:title>@endisset
            </image:image>
        @endisset
    </url>
@endforeach
</urlset>
