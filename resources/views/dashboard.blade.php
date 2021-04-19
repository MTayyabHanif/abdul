<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style=" display: inline-block; ">
            {{ __('Dashboard') }}
        </h2>
        <button class="new_task bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" style=" float: right; margin-top: -8px; ">
            Create New Task
        </button>
    </x-slot>

    <div id="new_task_modal" class="create_task_modal task_modal flex items-center justify-center fixed left-0 bottom-0 w-full h-full bg-gray-800 bg-opacity-80">
        <div class="bg-white rounded-lg w-1/2">
            <div class="flex flex-col items-start p-4">
                <div class="flex items-center w-full border-bottom-1 mb-4">
                    <div class="text-gray-900 font-medium text-lg">Create New Task</div>
                    <svg class="close_modal ml-auto fill-current text-gray-700 w-6 h-6 cursor-pointer"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                        <path
                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                    </svg>
                </div>
                <hr>



                <form action="/tasks/" method="POST" id="form" class="w-full">
                    @csrf
                    <div class="mb-6">
                        <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Task Name</label>
                        <input value="" type="text" name="name" id="name" required="" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500">
                    </div>
                    <div class="mb-6">
                        <label for="description" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Task Description</label>
                        <textarea rows="5" name="description" id="description" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" required=""></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="deadline" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Task Deadline</label>
                        <input value=""  type="datetime-local"  name="deadline" id="deadline" required="" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500">
                    </div>
                </form>


                <hr>
                <div class="ml-auto">
                    <button class="save_task bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Task
                    </button>
                    <button
                        class="close_modal bg-transparent hover:bg-gray-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($errors->any())
                {!! implode('', $errors->all('<div class="bg-red-500 font-semibold m-4 p-6 py-2 rounded shadow-md text-white">:message</div>')) !!}
            @endif


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="text-lg font-bold">{{ auth()->user()->name }}'s Tasks</p>


                    <!-- Table -->
                    <table
                        class='mt-4 mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
                        <thead class="bg-gray-50">
                        <tr class="text-gray-600 text-left">
                            <th class="font-semibold text-sm uppercase px-6 py-4">
                                Task
                            </th>
                            <th class="font-semibold text-sm uppercase px-6 py-4">
                                Description
                            </th>
                            <th class="font-semibold text-sm uppercase px-6 py-4 text-center">
                                Status
                            </th>
                            <th class="font-semibold text-sm uppercase px-6 py-4 text-center">
                                Due Date
                            </th>
                            <th class="font-semibold text-sm uppercase px-6 py-4"></th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @if(auth()->user()->tasks->count() > 0)
                            @foreach(auth()->user()->tasks->reverse() as $task)

                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            {{ $task->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="task-description">{{ $task->description }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                <span class="text-green-800 bg-green-200 font-semibold px-2 rounded-full">
                                Active
                                </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ Carbon\Carbon::parse($task->deadline)->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="javascript:void(0)" data-modal="task_modal_{{ $task->id }}" class="view_task text-purple-800 hover:underline">Edit</a>
                                    </td>
                                </tr>

                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @if(auth()->user()->tasks->count() > 0)
        @foreach(auth()->user()->tasks as $task)
            <div id="task_modal_{{$task->id}}" class="task_modal flex items-center justify-center fixed left-0 bottom-0 w-full h-full bg-gray-800 bg-opacity-80">
                <div class="bg-white rounded-lg w-1/2">
                    <div class="flex flex-col items-start p-4">
                        <div class="flex items-center w-full border-bottom-1 mb-4">
                            <div class="text-gray-900 font-medium text-lg">Edit Task "{{ $task->name }}"</div>
                            <svg class="close_modal ml-auto fill-current text-gray-700 w-6 h-6 cursor-pointer"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                <path
                                    d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                            </svg>
                        </div>
                        <hr>


                        <form action="/tasks/{{$task->id}}" method="POST" id="form" class="w-full">
                            {{ method_field('PUT') }}
                            @csrf
                            <div class="mb-6">
                                <label for="name_{{ $task->id }}" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Task Name</label>
                                <input value="{{ $task->name }}" type="text" name="name" id="name_{{ $task->id }}" required="" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500">
                            </div>
                            <div class="mb-6">
                                <label for="description_{{ $task->id }}" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Task Description</label>
                                <textarea rows="5" name="description" id="description_{{ $task->id }}" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" required="">{{ $task->description }}</textarea>
                            </div>

                            <div class="mb-6">
                                <label for="deadline_{{ $task->id }}" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Task Deadline</label>
                                <input value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($task->deadline)) }}"  type="datetime-local"  name="deadline" id="deadline_{{ $task->id }}" required="" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500">
                            </div>
                        </form>


                        <hr>
                        <div class="ml-auto">
                            <button class="save_task bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Task
                            </button>
                            <button
                                class="close_modal bg-transparent hover:bg-gray-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    @endif
</x-app-layout>
