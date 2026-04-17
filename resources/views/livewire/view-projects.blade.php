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
    <div class="flex flex-col gap-6 w-full ">

        {{-- table for displaying the list of current user's projects --}}
        <flux:table :paginate="$projects">
            <flux:table.columns>
                <flux:table.column>project title</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'start_date'" :direction="$sortDirection" wire:click="sort('start_date')">start date</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'description'" :direction="$sortDirection" wire:click="sort('description')">description</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'end_date'" :direction="$sortDirection" wire:click="sort('end_date')">end date</flux:table.column>
                <flux:table.column sortable >phase</flux:table.column>
                <flux:table.column sortable >created on</flux:table.column>
                <flux:table.column sortable >updated on </flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($projects as $project)
                    <flux:table.row :key="$project->id">
                        <flux:table.cell class="flex items-center gap-3">{{ $project->title }}</flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">{{ \Carbon\Carbon::parse($project->start_date)->format('d m Y') }}</flux:table.cell>

                        <flux:table.cell class="flex items-center gap-3">{{ str($project->description)->limit(50) }}</flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap"> {{ \Carbon\Carbon::parse($project->end_date)->format('d m Y')}}</flux:table.cell>

                        <flux:table.cell class="flex items-center gap-3">{{ $project->phase }}</flux:table.cell>
                        
                        <flux:table.cell class="whitespace-nowrap gap-3 p-2">{{ $project->{'created_at'} }}</flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap gap-3 p-2">{{ $project->{'updated_at'} }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"> </flux:button>
                                <flux:menu>        
                                    <flux:menu.item wire:click='editShow({{ $project->id }})' icon="pencil-square" kbd="⌘E">Edit</flux:menu.item>        
                                    <flux:menu.item wire:click='deleteProject({{ $project->id }})' icon="trash" variant="danger" kbd="⌘D">Delete</flux:menu.item>        
                                </flux:menu>
                           </flux:dropdown>
                           
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="7" class="text-center py-12 text-gray-500 italic">
                        <flux:icon icon="exclamation-triangle" variant="outline" class="mx-auto mb-2 opacity-20" />
                        No projects available
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
                       
            </flux:table.rows>
        </flux:table>

    </div>

    {{-- Modal for editing the selected project --}}

    {{-- no csrf required --}}
    <flux:modal name="edit-modal" class="md:w-96" >
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Update project</flux:heading>
                <flux:text class="mt-2">Make changes to your project.</flux:text>
            </div>

            <flux:input wire:model='selectedItem.title' label="Title" placeholder="{{ $this->selectedItem['title'] }}" />
       
            <div class="flex"></div>           
           <flux:textarea wire:model='selectedItem.description' label="Description" class="resize rounded-md" placeholder="selectedItem.description"  />
       
            <div class="flex"></div>
            <flux:input wire:model='selectedItem.startDate' label="Start date" type="date" placeholder="selectedItem.startDate"/>

            <div class="flex"></div>
            <flux:input wire:model='selectedItem.endDate' label="End date" type="date" placeholder="selectedItem.endDate" />
   
            <div class="flex"></div>

   
            <flux:select wire:model='selectedItem.phase' label="Phase"  placeholder="Select a phase" placeholder="selectedItem.phase">
                <flux:select.option value="design">Design</flux:select.option>
                <flux:select.option value="development">Development</flux:select.option>
                <flux:select.option value="testing">Testing</flux:select.option>
                <flux:select.option value="deployment">Deployment</flux:select.option>
                <flux:select.option value="complete">Complete</flux:select.option>
            </flux:select>  
        
            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" wire:click="updateProject({{ $this->selectedItem['id'] }})" variant="primary" color="green">Save changes</flux:button>
                <flux:modal.close >
                    <flux:button variant="ghost">Close</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
