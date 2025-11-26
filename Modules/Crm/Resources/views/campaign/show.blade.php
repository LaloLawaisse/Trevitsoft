<div class="modal-dialog" role="document">
    <div class="modal-content rounded-lg shadow-lg">
        {{-- Modal Header --}}
        <div class="modal-header flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
            <h4 class="text-lg font-semibold text-gray-900">
                {{ $campaign->name }}
            </h4>
            <button type="button" class="text-gray-500 hover:text-gray-700" data-dismiss="modal" aria-label="Close">
                <span class="text-2xl leading-none">&times;</span>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="modal-body p-6 space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
                <div>
                    <strong>@lang('crm::lang.campaign_type'):</strong>
                    @if($campaign->campaign_type == "sms")
                        {{ __("crm::lang.sms") }}
                    @elseif($campaign->campaign_type == "email")
                        {{ __("business.email") }}
                    @endif
                </div>
                @if(!empty($campaign->sent_on))
                    <div class="text-right">
                        <strong>@lang('crm::lang.sent_on'):</strong> 
                        {{ @format_datetime($campaign->sent_on) }}
                    </div>
                @endif
            </div>

            {{-- Email Campaign --}}
            @if($campaign->campaign_type == 'email')
                <div>
                    <strong>@lang('crm::lang.subject'):</strong>
                    <p class="text-gray-800 mt-1">{{ $campaign->subject }}</p>
                </div>
                <div>
                    <strong>@lang('crm::lang.email_body'):</strong>
                    <div class="prose max-w-full mt-1">
                        {!! $campaign->email_body !!}
                    </div>
                </div>
            @elseif($campaign->campaign_type == 'sms')
                <div>
                    <strong>@lang('crm::lang.sms_body'):</strong>
                    <p class="text-gray-800 mt-1">{!! $campaign->sms_body !!}</p>
                </div>
            @endif

            {{-- Transaction Activity --}}
            @if(!empty($campaign->additional_info['to']) && $campaign->additional_info['to'] == 'transaction_activity')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <strong>@lang('crm::lang.transaction_activity'):</strong>
                        @lang('crm::lang.'.$campaign->additional_info['trans_activity'])
                    </div>
                    <div>
                        <strong>@lang('crm::lang.in_days'):</strong>
                        {{ $campaign->additional_info['in_days'] }}
                    </div>
                </div>
            @endif

            {{-- Leads and Customers --}}
            @php
                $leads = []; $customers = [];
            @endphp
            @if(count($notifiable_users) > 0) 
                @foreach($notifiable_users as $contact) 
                    @php
                        if($contact->type == 'lead') $leads[] = $contact->name;
                        if($contact->type == 'customer') $customers[] = $contact->name;
                    @endphp
                @endforeach 
            @endif

            <div class="space-y-3">
                @if(!empty($customers))
                    <div>
                        <strong>@lang('lang_v1.customers'):</strong>
                        <p class="text-gray-800">{{ implode(', ', $customers) }}</p>
                    </div>
                @endif
                @if(!empty($leads))
                    <div>
                        <strong>@lang('crm::lang.leads'):</strong>
                        <p class="text-gray-800">{{ implode(', ', $leads) }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="modal-footer flex justify-between items-center px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-lg text-sm text-gray-600">
            <div class="flex items-center space-x-2">
                <i class="fas fa-pencil-alt text-gray-400"></i>
                <span>
                    @lang('crm::lang.created_this_campaign_on', ['name' => $campaign->createdBy->user_full_name]) 
                    {{ @format_date($campaign->created_at) }}
                </span>
            </div>
            <button type="button" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm" data-dismiss="modal">
                @lang('messages.close')
            </button>
        </div>
    </div>
</div>
