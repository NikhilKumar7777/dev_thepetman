<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Post::with(['categories', 'user'])->select(sprintf('%s.*', (new Post())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'post_show';
                $editGate = 'post_edit';
                $deleteGate = 'post_delete';
                $crudRoutePart = 'posts';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('images', function ($row) {
                if (!$row->images) {
                    return '';
                }
                $links = [];
                foreach ($row->images as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });
            $table->editColumn('like_count', function ($row) {
                return $row->like_count ? $row->like_count : '';
            });
            $table->editColumn('unlike_count', function ($row) {
                return $row->unlike_count ? $row->unlike_count : '';
            });
            $table->editColumn('view_count', function ($row) {
                return $row->view_count ? $row->view_count : '';
            });
            $table->editColumn('is_report', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_report ? 'checked' : null) . '>';
            });
            $table->editColumn('answer_count', function ($row) {
                return $row->answer_count ? $row->answer_count : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? Post::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('category', function ($row) {
                $labels = [];
                foreach ($row->categories as $category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $category->title);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('option_1', function ($row) {
                return $row->option_1 ? $row->option_1 : '';
            });
            $table->editColumn('option_2', function ($row) {
                return $row->option_2 ? $row->option_2 : '';
            });
            $table->editColumn('option_3', function ($row) {
                return $row->option_3 ? $row->option_3 : '';
            });
            $table->editColumn('option_4', function ($row) {
                return $row->option_4 ? $row->option_4 : '';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'images', 'is_report', 'category', 'user']);

            return $table->make(true);
        }

        return view('admin.posts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('title', 'id');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.posts.create', compact('categories', 'users'));
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->all());
        $post->categories()->sync($request->input('categories', []));
        foreach ($request->input('images', []) as $file) {
            $post->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $post->id]);
        }

        return redirect()->route('admin.posts.index');
    }

    public function edit(Post $post)
    {
        abort_if(Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('title', 'id');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $post->load('categories', 'user');

        return view('admin.posts.edit', compact('categories', 'post', 'users'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());
        $post->categories()->sync($request->input('categories', []));
        if (count($post->images) > 0) {
            foreach ($post->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $post->images->pluck('file_name')->toArray();
        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $post->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.posts.index');
    }

    public function show(Post $post)
    {
        abort_if(Gate::denies('post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->load('categories', 'user', 'postReportsAbuses', 'postVotes', 'postComments', 'postLikes', 'postDislikes', 'postViews');

        return view('admin.posts.show', compact('post'));
    }
 
    public function destroy(Post $post)
    {
        abort_if(Gate::denies('post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->delete();

        return back();
    }

    public function massDestroy(MassDestroyPostRequest $request)
    {
        Post::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('post_create') && Gate::denies('post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Post();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
