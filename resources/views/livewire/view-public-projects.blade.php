
<div>

    {{-- This is the filter div --}}
    <div class="flex flex-row-reverse">
        <flux:dropdown>
            <flux:button icon:trailing="funnel" size="xs"></flux:button>

            <flux:menu>
               
            {{-- Filter section added setFilter call to method empty otherwise won't refresh the ajax  --}}

            <flux:checkbox.group wire:model="filter" label="Phases" variant="pills" wire:click='setFilter'>
                <flux:checkbox value="Testing" label="Testing" />
                <flux:checkbox value="Development" label="Development" />
                <flux:checkbox value="Deployment" label="Deployment" />
                <flux:checkbox value="Design" label="Design" />
                <flux:checkbox value="Complete" label="Complete" />
            </flux:checkbox.group>
                <flux:menu.separator /> 
                  <flux:input wire:model.live.debounce.300ms="search" kbd="⌘K" icon="magnifying-glass" placeholder="Search in title or start date..."
               autocomplete="off" x-on:input="open = true" x-on:click.away="open = false" x-on:keydown.escape="open = false"/>
            </flux:menu>
        </flux:dropdown>
    </div>
    <br>
    <div class="flex flex-col gap-4 w-full ">

        {{-- table for displaying the list of current user's projects --}}
        <flux:table :paginate="$projects">
            <flux:table.columns>
                <flux:table.column>project title</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'start_date'" :direction="$sortDirection" wire:click="sort('start_date')">start date</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'description'" :direction="$sortDirection" wire:click="sort('description')">description</flux:table.column>          
                <flux:table.column >phase</flux:table.column>


            </flux:table.columns>

            <flux:table.rows>
                @forelse ($projects as $project)
                    <flux:table.row :key="$project->id" wire:click='viewProjectDetailsModal({{ $project->id }})'>
                        <flux:table.cell class="whitespace-nowrap gap-3 p-2">{{ $project->title }}</flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap p-2">{{ \Carbon\Carbon::parse($project->start_date)->format('d m Y') }}</flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap gap-3 p-2">{{ str($project->description)->limit(50) }}</flux:table.cell>

                      
                        <flux:table.cell class="whitespace-nowrap gap-3 p-2">{{ $project->phase }}</flux:table.cell>

                       

                        
                       
   
                    </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="4" class="text-center py-12 text-gray-500 italic">
                        <flux:icon icon="exclamation-triangle" variant="outline" class="mx-auto mb-2 opacity-20" />
                        No projects available
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

    </div>
{{-- View project details modal --}}


<flux:modal name="project-info" class="md:w-96">
    <div class="space-y-6">
        <div class="gap-2">
            <flux:heading size="lg">Project details</flux:heading>
            <flux:text class="mt-2">All information about this project.</flux:text>
        </div>
        <flux:text variant="strong">Title</flux:text>
        <flux:text class="">{{ $this->projectInfo['title'] }}</flux:text>
        <flux:text variant="strong">Description</flux:text>
        <flux:text class="">{{ $this->projectInfo['description'] }}</flux:text>
        <flux:text variant="strong">Start date</flux:text>
        <flux:text class="">{{ $this->projectInfo['start_date'] }}</flux:text>
        <flux:text variant="strong">End Date</flux:text>
        <flux:text class="">{{ $this->projectInfo['end_date'] }}</flux:text>
        <flux:text variant="strong">Phase</flux:text>
        <flux:text class="">{{ $this->projectInfo['phase'] }}</flux:text>
        <flux:text variant="strong">Creator email</flux:text>
        <flux:text class="">{{ $this->projectInfo['email'] }}</flux:text>
        <div class="flex">
            <flux:spacer />

        <flux:modal.close >
            <flux:button variant="ghost">Close</flux:button>
        </flux:modal.close>
        </div>
    </div>
</flux:modal>
   
</div>
