<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\NewsletterSubscriber;
use App\Models\DashboardUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NewsArticleController extends Controller
{
    private function authorizeEditor()
    {
        $user = DashboardUser::find(session('dashboard_user_id'));
        if (!$user || !in_array($user->role, ['super_admin', 'content_editor'])) {
            abort(403, 'غير مصرح لك بالوصول لإدارة الأخبار.');
        }
    }

    public function index()
    {
        $this->authorizeEditor();
        $articles = NewsArticle::orderByDesc('published_at')->get();
        return inertia('News/Index', ['articles' => $articles]);
    }

    public function create()
    {
        $this->authorizeEditor();
        return inertia('News/Form', ['article' => null]);
    }

    public function store(Request $request)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'cover_file' => 'required|image|max:3072',
            'published_at' => 'nullable|date',
        ]);

        $slug = preg_replace('/\s+/u', '-', trim($validated['title_ar']));
        $slug = preg_replace('/-+/', '-', $slug);

        $path = $request->file('cover_file')->store('news', 'public');

        $article = NewsArticle::create([
            'title_ar' => $validated['title_ar'],
            'title_en' => $validated['title_en'],
            'slug' => $slug,
            'content_ar' => $validated['content_ar'],
            'content_en' => $validated['content_en'],
            'status' => $validated['status'],
            'cover_image_url' => '/storage/' . $path,
            'author_id' => session('dashboard_user_id'),
            'published_at' => $validated['published_at'] ?? now(),
        ]);
        Log::info('New article created: ' . $article->id);
        // Trigger emails if published immediately
        if ($article->status === 'published') {
            $this->sendNotificationToSubscribers($article);
        }
        Log::info('New article status: ' . $article->status);

        return redirect('/admin/news')->with('success', 'تم نشر المقال الخبري بنجاح');
    }

    public function update(Request $request, NewsArticle $article)
    {
        $this->authorizeEditor();

        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'cover_file' => 'nullable|image|max:3072',
            'published_at' => 'nullable|date',
        ]);

        $slug = preg_replace('/\s+/u', '-', trim($validated['title_ar']));
        $slug = preg_replace('/-+/', '-', $slug);

        $oldStatus = $article->status;

        $updateData = [
            'title_ar' => $validated['title_ar'],
            'title_en' => $validated['title_en'],
            'slug' => $slug,
            'content_ar' => $validated['content_ar'],
            'content_en' => $validated['content_en'],
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? $article->published_at,
        ];

        if ($request->hasFile('cover_file')) {
            $oldPath = str_replace('/storage/', '', $article->cover_image_url);
            Storage::disk('public')->delete($oldPath);

            $path = $request->file('cover_file')->store('news', 'public');
            $updateData['cover_image_url'] = '/storage/' . $path;
        }

        $article->update($updateData);

        // Trigger emails if status transitioned from draft to published
        if ($article->status === 'published' && $oldStatus !== 'published') {
            $this->sendNotificationToSubscribers($article);
        }
        Log::info('New article status: ' . $article->status . ", old status: " . $oldStatus); ;

        return redirect('/admin/news')->with('success', 'تم تحديث المقال الخبري بنجاح');
    }

    public function edit(NewsArticle $article)
    {
        $this->authorizeEditor();
        return inertia('News/Form', ['article' => $article]);
    }

    public function destroy(NewsArticle $article)
    {
        $this->authorizeEditor();

        $filePath = str_replace('/storage/', '', $article->cover_image_url);
        Storage::disk('public')->delete($filePath);

        $article->delete();
        return redirect('/admin/news')->with('success', 'تم حذف المقال الخبري بنجاح');
    }

    /** Dispatch closure-based queue job to notify subscribers */
    /** Send email notifications directly to active subscribers */
    private function sendNotificationToSubscribers(NewsArticle $article)
    {
        Log::info("Sending news email to subscribers");
        $subscribers = NewsletterSubscriber::where('is_active', true)->pluck('email')->toArray();
        Log::info("Found " . count($subscribers) . " active subscribers.");
        
        if (empty($subscribers)) {
            Log::info("No active subscribers found.");
            return;
        }
        
        Log::info("Starting synchronous mailing loop");
        foreach ($subscribers as $email) {
            Log::info("Sending news email to: {$email}");
            try {
                Mail::send('emails.new-article', ['article' => $article], function ($message) use ($email, $article) {
                    $message->to($email)
                            ->subject('خبر جديد من  متراحمين الخيرية: ' . $article->title_ar);
                });

                // Write a log record to the database upon successful delivery
                \App\Models\SentEmail::create([
                    'recipient' => $email,
                    'subject'   => 'خبر جديد من  متراحمين الخيرية: ' . $article->title_ar
                ]);

                Log::info("Successfully sent news email to: {$email}");
            } catch (\Exception $e) {
                Log::error("Failed to send news email to {$email}: " . $e->getMessage());
            }
        }
    }
}