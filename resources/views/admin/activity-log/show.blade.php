<!-- resources/views/admin/activity-log/show.blade.php -->
@php
    $activity = $activity ?? $activityLog ?? null;
    if (!$activity) {
        echo '<div class="text-red-600">Activity not found</div>';
        return;
    }
@endphp

<div class="space-y-6">
    <!-- Activity Header -->
    <div class="border-b border-gray-200 pb-4">
        <div class="flex justify-between items-start">
            <div>
                <h4 class="text-lg font-bold text-gray-800">{{ $activity->description }}</h4>
                <div class="flex items-center mt-2 space-x-4">
                    @php
                        $badgeColors = [
                            'LOGIN' => 'bg-green-100 text-green-800',
                            'CREATE' => 'bg-blue-100 text-blue-800',
                            'UPDATE' => 'bg-yellow-100 text-yellow-800',
                            'DELETE' => 'bg-red-100 text-red-800',
                            'FORM_SUBMIT' => 'bg-purple-100 text-purple-800',
                            'VIEW' => 'bg-gray-100 text-gray-800'
                        ];
                        $badgeClass = $badgeColors[$activity->activity_type] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $badgeClass }}">
                        {{ $activity->activity_type }}
                    </span>
                    <span class="text-sm text-gray-600">
                        <i class="far fa-clock mr-1"></i>
                        {{ $activity->created_at->format('d M Y H:i:s') }}
                    </span>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Activity ID</div>
                <div class="font-mono text-gray-700">#{{ $activity->id }}</div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div>
        <h5 class="text-sm font-medium text-gray-700 mb-3">User Information</h5>
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="flex items-center">
                        @if($activity->user)
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm mr-3">
                            {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $activity->user->name }}</div>
                            <div class="text-sm text-gray-600">{{ $activity->user->email }}</div>
                        </div>
                        @else
                        <div>
                            <div class="font-medium text-gray-900">System</div>
                            <div class="text-sm text-gray-600">Automated process</div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="space-y-2">
                    <div>
                        <span class="text-sm text-gray-600">IP Address:</span>
                        <code class="ml-2 text-sm bg-gray-100 px-2 py-1 rounded">{{ $activity->ip_address }}</code>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">User Agent:</span>
                        <div class="text-sm text-gray-900 truncate">{{ $activity->user_agent }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Information -->
    <div>
        <h5 class="text-sm font-medium text-gray-700 mb-3">Request Information</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-600 mb-1">HTTP Method</div>
                <div class="font-medium text-gray-900">
                    <span class="px-2 py-1 rounded text-sm 
                        @if($activity->method == 'GET') bg-blue-100 text-blue-800
                        @elseif($activity->method == 'POST') bg-green-100 text-green-800
                        @elseif($activity->method == 'PUT') bg-yellow-100 text-yellow-800
                        @elseif($activity->method == 'DELETE') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $activity->method }}
                    </span>
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                <div class="text-sm text-gray-600 mb-1">URL</div>
                <div class="font-medium text-gray-900 break-all">
                    <a href="{{ $activity->url }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ $activity->url }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Changes (if any) -->
    @if($activity->old_data || $activity->new_data)
    <div>
        <h5 class="text-sm font-medium text-gray-700 mb-3">Data Changes</h5>
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($activity->old_data)
                <div>
                    <h6 class="text-sm font-medium text-red-600 mb-2">Before</h6>
                    <div class="bg-white rounded border border-red-200 p-3 max-h-60 overflow-y-auto">
                        <pre class="text-sm text-gray-800 whitespace-pre-wrap">{{ json_encode($activity->old_data, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
                @endif
                
                @if($activity->new_data)
                <div>
                    <h6 class="text-sm font-medium text-green-600 mb-2">After</h6>
                    <div class="bg-white rounded border border-green-200 p-3 max-h-60 overflow-y-auto">
                        <pre class="text-sm text-gray-800 whitespace-pre-wrap">{{ json_encode($activity->new_data, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
                @endif
            </div>
            
            @if($activity->model_type && $activity->model_id)
            <div class="mt-4 text-sm text-gray-600">
                Model: <span class="font-medium">{{ class_basename($activity->model_type) }}</span>
                @if($activity->model_id)
                (ID: <span class="font-medium">{{ $activity->model_id }}</span>)
                @endif
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Form Data (if FORM_SUBMIT) -->
    @if($activity->activity_type == 'FORM_SUBMIT' && $activity->hasFormData())
    <div>
        <h5 class="text-sm font-medium text-gray-700 mb-3">Form Submission Data</h5>
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Field</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($activity->getCleanedFormData() as $key => $value)
                        @if(!empty($value))
                        <tr>
                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $key }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                @if(is_array($value) || is_object($value))
                                <pre class="text-xs whitespace-pre-wrap">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                @else
                                {{ $value }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                Total fields: {{ count($activity->getCleanedFormData()) }}
            </div>
        </div>
    </div>
    @endif

    <!-- Additional Information -->
    <div class="border-t border-gray-200 pt-4">
        <h5 class="text-sm font-medium text-gray-700 mb-3">Additional Information</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-gray-600">Created At</div>
                <div class="font-medium text-gray-900">{{ $activity->created_at->format('d M Y H:i:s') }}</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-gray-600">Updated At</div>
                <div class="font-medium text-gray-900">{{ $activity->updated_at->format('d M Y H:i:s') }}</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-gray-600">Time Since</div>
                <div class="font-medium text-gray-900">{{ $activity->created_at->diffForHumans() }}</div>
            </div>
        </div>
    </div>
</div>