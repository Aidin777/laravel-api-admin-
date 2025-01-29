<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonTest;
use App\Models\LessonVideo;
use App\Models\Theme;
use App\Models\UserTestProgress;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function galaxy(Request $request)
    {
        $themes = Theme::get()->map(function ($theme) use ($request) {
            $lessonCount = $theme->lessons->count();

            $completedLessonsCount = $theme->lessons->flatMap(function ($lesson) use ($request) {
                if($lesson->progress !== null) {
                    return $lesson->progress
                        ->where('is_lesson_complete', true)
                        ->where('lesson_id', $lesson->id)
                        ->where('user_id', $request->user()->id)
                        ->get();
                }
                return 0;
            })->count();


            $theme->lesson_count = $lessonCount;
            $theme->completed_lessons_count = $completedLessonsCount;
            unset($theme->lessons);
            return $theme;
        });

        return $themes;
    }
    public function galaxyLessons($theme, Request $request)
    {
        $theme = Theme::where('slug', $theme)->firstOrFail();
        $lessons = $theme->lessons->load([
            'lessonVideo',
            'lessonTest',
            'presentation',
            'theme:id,title,description,short_description',
            'progress' => function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            }
        ]);

        return $lessons;


    }


    public function video ($slug)
    {
        $lesson = Lesson::where('slug',$slug)->firstOrFail();
        return $lesson->lessonVideo;
    }
    public function test ($slug)
    {
        $lesson = Lesson::where('slug',$slug)->firstOrFail();
        return $lesson->lessonTest;
    }

    public function updateProgress(Request $request)
    {
        $user = $request->user();
        $lesson = Lesson::where('slug', $request->lesson_slug)->first();
        $data = [];

        if ($request->has('is_video_watched')) {
            $data['is_video_watched'] = true;
        }

        if ($request->has('is_test_finished')) {
            $data['is_test_finished'] = true;
        }
        if ($request->has('test_progress')) {
            $data['test_progress'] = $request->test_score;
        }

        $progress = $lesson->progress()->updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lesson->id],
            $data
        );

        if ($progress->is_video_watched && $progress->is_test_finished) {
            $progress->update(['is_lesson_complete' => true]);
        }
    }

    public function downloadPresentation(Request $request)
    {
        $lesson = Lesson::where('slug', $request->lesson_slug)->first();
        return $lesson->presentation->link;
    }
}
