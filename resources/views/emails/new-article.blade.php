<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 20px;
            direction: rtl;
            text-align: right;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(13, 27, 62, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #0D1B3E;
            padding: 32px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 20px;
            font-weight: 800;
        }
        .header p {
            color: #F5831F;
            margin: 4px 0 0 0;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        .content {
            padding: 32px 24px;
        }
        .cover-wrapper {
            width: 100%;
            height: auto;
            max-height: 260px;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 24px;
            background-color: #0D1B3E;
        }
        .cover-image {
            width: 100%;
            height: auto;
            display: block;
        }
        .title-ar {
            color: #0D1B3E;
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 12px 0;
            line-height: 1.4;
        }
        .title-en {
            color: #4a5568;
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 16px 0;
            line-height: 1.4;
            direction: ltr;
            text-align: left;
        }
        .text-ar {
            color: #4a5568;
            font-size: 14px;
            line-height: 1.8;
            margin: 0 0 24px 0;
        }
        .text-en {
            color: #718096;
            font-size: 13.5px;
            line-height: 1.7;
            margin: 0 0 24px 0;
            direction: ltr;
            text-align: left;
        }
        .btn-wrapper {
            text-align: center;
            margin-block: 28px 12px;
        }
        .btn {
            display: inline-block;
            background-color: #F5831F;
            color: #ffffff !important;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            font-size: 13.5px;
            box-shadow: 0 4px 12px rgba(245, 131, 31, 0.25);
        }
        .footer {
            background-color: #f8fafc;
            padding: 24px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px solid #edf2f7;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Brand Header -->
        <div class="header">
            <h1>منظمة متراحمين الخيرية الخيرية</h1>
            <p>ZelalAlrahma.org</p>
        </div>

        <!-- Body -->
        <div class="content">
            <!-- Article Image -->
            @if($article->cover_image_url)
                <div class="cover-wrapper">
                    <img class="cover-image" src="{{ asset($article->cover_image_url) }}" alt="News Cover">
                </div>
            @endif

            <!-- Arabic Title -->
            <h2 class="title-ar">{{ $article->title_ar }}</h2>
            
            <!-- English Title (if present) -->
            @if($article->title_en)
                <h3 class="title-en">{{ $article->title_en }}</h3>
            @endif

            <!-- Arabic Snippet -->
            <p class="text-ar">
                {{ Str::limit(strip_tags($article->content_ar), 180) }}
            </p>

            <!-- English Snippet (if present) -->
            @if($article->content_en)
                <p class="text-en">
                    {{ Str::limit(strip_tags($article->content_en), 180) }}
                </p>
            @endif

            <!-- Link CTA Button -->
            <div class="btn-wrapper">
                <a href="{{ route('news.show', $article->slug) }}" class="btn">
                    اقرأ الخبر كاملاً / Read Full Article
                </a>
            </div>
        </div>

        <!-- Footer terms -->
        <div class="footer">
            لقد تلقيت هذا البريد الإلكتروني لأنك مشترك في النشرة البريدية لمنظمة متراحمين الخيرية .<br>
            You received this email because you are subscribed to Zelal Al-Rahma newsletter.<br>
            © {{ date('Y') }} Zelal Al-Rahma. All rights reserved.
        </div>
    </div>
</body>
</html>