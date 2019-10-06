{{-- this file contains php/laravel authenticaion logic that's why we use it inside
inline template of Vue component. (this file will be use with Answer-old) --}}
<answer :answer-model="{{$answer}}" inline-template>
    <div class="media media-item">
        {{--@include('partials._vote', ['model' => $answer])--}}
        <vote model-name="answer" :model="{{$answer}}"></vote>

        <div class="media-body">
            <form v-if="editing" @submit.prevent="updateAnswer">
                <div class="form-group">
                    <textarea v-model="body" rows="10" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-outline-primary" :disabled="isInvalid">Update</button>
                <button type="button" class="btn btn-outline-secondary" @click="onCancel">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>

                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            {{-- this authorization functionality created in AuthServiceProvider using Gate --}}
                            {{--@if (auth()->user()->can('update-question', $answer)) @endif--}}

                            {{-- this authorization functionality created in QuestionPolicy using Policy --}}
                            {{-- instead of using if statement and check with authenticated user we can just use @can directive --}}
                            @can ('update', $answer)
                                <a @click.prevent="onEdit" class="btn btn-outline-info btn-sm">Edit</a>
                            @endcan

                            {{--@if (auth()->user()->can('delete-question', $answer)) @endif--}}
                            @can ('delete', $answer)
                                <button class="btn btn-sm btn-outline-danger" @click="deleteAnswer">
                                    Delete
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        {{--@include('partials._author', ['model'=>$answer, 'label'=>'Answered'])--}}
                        <user-info :model="{{$answer}}" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer>
