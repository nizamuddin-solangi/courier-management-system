@extends('admin.layouts.admin')

@section('title', 'Onboard Fleet Agent')

@section('content')

<style>
    .wizard-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 1rem;
        min-height: calc(100vh - 150px);
        display: flex;
        flex-direction: column;
    }

    /* Top Progress Bar indicator */
    .progress-tracker {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4rem;
        position: relative;
    }

    .progress-tracker::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        height: 2px;
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        z-index: 0;
    }

    .progress-bar-fill {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        height: 2px;
        background: #66FCF1;
        z-index: 1;
        transition: width 0.4s ease;
    }

    .step-indicator {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .step-circle {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background: #0B0C10;
        border: 2px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: rgba(255, 255, 255, 0.3);
        transition: all 0.4s ease;
    }

    .step-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: rgba(255, 255, 255, 0.3);
        transition: all 0.4s ease;
    }

    /* Active Step Styling */
    .step-indicator.active .step-circle {
        border-color: #66FCF1;
        color: #66FCF1;
        box-shadow: 0 0 20px rgba(102, 252, 241, 0.2);
    }
    .step-indicator.active .step-label {
        color: #66FCF1;
    }

    /* Completed Step Styling */
    .step-indicator.completed .step-circle {
        background: #66FCF1;
        border-color: #66FCF1;
        color: #0B0C10;
    }
    .step-indicator.completed .step-label {
        color: rgba(255, 255, 255, 0.7);
    }

    /* Step Panels */
    .step-panel {
        display: none;
        animation: fadeSlideUp 0.4s ease forwards;
        flex: 1;
    }
    .step-panel.active {
        display: block;
    }

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Centered Huge Typography Inputs for Wizard */
    .wizard-field {
        margin-bottom: 2.5rem;
    }

    .wizard-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #C5C6C7;
        margin-bottom: 0.75rem;
    }

    .wizard-input-wrapper {
        position: relative;
    }

    .wizard-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 1rem;
        font-size: 1.125rem;
        padding: 1.25rem 1.5rem;
        color: #fff;
        transition: all 0.3s;
    }

    .wizard-input:focus {
        outline: none;
        background: rgba(0, 0, 0, 0.4);
        border-color: #45A29E;
        box-shadow: 0 0 0 4px rgba(69, 162, 158, 0.1);
    }
    
    .wizard-input::placeholder {
        color: rgba(197, 198, 199, 0.2);
    }

    /* Navigation Buttons */
    .wizard-footer {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px dashed rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
    }

    .btn-wizard {
        padding: 1rem 2.5rem;
        border-radius: 3rem;
        font-weight: 800;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .btn-prev {
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.1);
        color: #C5C6C7;
    }
    .btn-prev:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .btn-next {
        background: #66FCF1;
        color: #0B0C10;
        border: 2px solid #66FCF1;
        box-shadow: 0 10px 20px rgba(102, 252, 241, 0.15);
        margin-left: auto;
    }
    .btn-next:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(102, 252, 241, 0.3);
    }
</style>

<div class="wizard-container">
    
    <div class="text-center mb-10">
        <h2 class="text-4xl font-black text-white tracking-tight">Agent Provisioning</h2>
        <p class="text-[#45A29E] mt-2 font-medium">Follow the sequence to initialize new fleet personnel</p>
    </div>

    @if(session('success'))
    <div class="p-4 mb-8 rounded-2xl bg-[#10B981]/10 border border-[#10B981]/20 text-[#10B981] font-bold text-center">
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="p-4 mb-8 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-500 font-bold text-center">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <!-- The Progress Tracker -->
    <div class="progress-tracker">
        <div class="progress-bar-fill" id="progressBar" style="width: 0%;"></div>
        
        <div class="step-indicator active" id="indicator-1">
            <div class="step-circle"><i class="bi bi-fingerprint"></i></div>
            <div class="step-label">Access</div>
        </div>
        <div class="step-indicator" id="indicator-2">
            <div class="step-circle"><i class="bi bi-person-vcard"></i></div>
            <div class="step-label">Identity</div>
        </div>
        <div class="step-indicator" id="indicator-3">
            <div class="step-circle"><i class="bi bi-geo-alt"></i></div>
            <div class="step-label">Location</div>
        </div>
        <div class="step-indicator" id="indicator-4">
            <div class="step-circle"><i class="bi bi-diagram-3"></i></div>
            <div class="step-label">Logistics</div>
        </div>
    </div>

    <form action="{{ route('admin.store_agent') }}" method="POST" id="agentWizardForm">
        @csrf
        
        <!-- STEP 1: System Access -->
        <div class="step-panel active" id="step-1">
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-white">System Access</h3>
                <p class="text-[#C5C6C7] opacity-60 mt-1">Setup the operative's portal authentication.</p>
            </div>

            <div class="wizard-field">
                <label class="wizard-label">Operative CID</label>
                <input type="text" name="agent_code" value="AGT-{{ rand(1000, 9999) }}" class="wizard-input text-[#66FCF1] font-mono pointer-events-none" readonly>
            </div>
            
            <div class="wizard-field">
                <label class="wizard-label">Username</label>
                <input type="text" name="username" class="wizard-input" placeholder="e.g. operative_john">
            </div>

            <div class="wizard-field">
                <label class="wizard-label">Portal Password</label>
                <input type="password" name="password" class="wizard-input" placeholder="••••••••">
            </div>
            
        </div>

        <!-- STEP 2: Identity -->
        <div class="step-panel" id="step-2">
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-white">Personal Identity</h3>
                <p class="text-[#C5C6C7] opacity-60 mt-1">Official demographics and comms.</p>
            </div>

            <div class="wizard-field">
                <label class="wizard-label">Full Legal Name</label>
                <input type="text" name="name" class="wizard-input" placeholder="Enter operative name">
            </div>
            
            <div class="flex gap-4">
                <div class="wizard-field flex-1">
                    <label class="wizard-label">Email Address</label>
                    <input type="email" name="email" class="wizard-input" placeholder="agent@fleet.net">
                </div>
                <div class="wizard-field flex-1">
                    <label class="wizard-label">Contact Number</label>
                    <input type="text" name="phone" class="wizard-input" placeholder="+1 (000) 000-0000">
                </div>
            </div>
        </div>

        <!-- STEP 3: Location -->
        <div class="step-panel" id="step-3">
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-white">Base Location</h3>
                <p class="text-[#C5C6C7] opacity-60 mt-1">Residential base for the operative.</p>
            </div>

            <div class="wizard-field">
                <label class="wizard-label">Home City</label>
                <input type="text" name="city" class="wizard-input" placeholder="Metropolis">
            </div>

            <div class="wizard-field">
                <label class="wizard-label">Full Residential Address</label>
                <textarea name="address" class="wizard-input" rows="3" placeholder="123 Fleet Street, Sector B..."></textarea>
            </div>
        </div>

        <!-- STEP 4: Logistics -->
        <div class="step-panel" id="step-4">
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-white">Logistics Assignment</h3>
                <p class="text-[#C5C6C7] opacity-60 mt-1">Set operational bounds and hubs.</p>
            </div>

            <div class="wizard-field">
                <label class="wizard-label">Branch Assignment</label>
                <input type="text" name="branch_name" class="wizard-input" placeholder="e.g. Northern Hub / NY Base">
            </div>

            <div class="flex gap-4">
                <div class="wizard-field flex-1">
                    <label class="wizard-label">Jurisdiction Origin (From)</label>
                    <input type="text" name="from_city" class="wizard-input" placeholder="City A">
                </div>
                <div class="wizard-field flex-1">
                    <label class="wizard-label">Jurisdiction Target (To)</label>
                    <input type="text" name="to_city" class="wizard-input" placeholder="City B">
                </div>
            </div>
        </div>

        <!-- Wizard Navigation -->
        <div class="wizard-footer">
            <button type="button" class="btn-wizard btn-prev" id="btnPrev" style="visibility: hidden;">
                <i class="bi bi-arrow-left"></i> Previous
            </button>
            <button type="button" class="btn-wizard btn-next" id="btnNext">
                Next Phase <i class="bi bi-arrow-right"></i>
            </button>
            <button type="submit" class="btn-wizard btn-next" id="btnSubmit" style="display: none;">
                Deploy Agent <i class="bi bi-check2-circle"></i>
            </button>
        </div>

    </form>
</div>

<!-- Simple Vanilla JS for Wizard logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalSteps = 4;
        let currentStep = 1;

        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');
        const progressBar = document.getElementById('progressBar');

        function updateWizard() {
            // Update Panels
            for(let i = 1; i <= totalSteps; i++) {
                document.getElementById('step-' + i).classList.remove('active');
            }
            document.getElementById('step-' + currentStep).classList.add('active');

            // Update Indicators
            for(let i = 1; i <= totalSteps; i++) {
                let ind = document.getElementById('indicator-' + i);
                ind.classList.remove('active', 'completed');
                
                if (i < currentStep) {
                    ind.classList.add('completed');
                    ind.querySelector('i').className = 'bi bi-check-lg'; // change icon to check
                } else if (i === currentStep) {
                    ind.classList.add('active');
                    // Reset icons based on origin
                    const icons = ['bi-fingerprint', 'bi-person-vcard', 'bi-geo-alt', 'bi-diagram-3'];
                    ind.querySelector('i').className = 'bi ' + icons[i-1];
                } else {
                    const icons = ['bi-fingerprint', 'bi-person-vcard', 'bi-geo-alt', 'bi-diagram-3'];
                    ind.querySelector('i').className = 'bi ' + icons[i-1];
                }
            }

            // Update Progress Bar (assuming 3 segments between 4 steps)
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
            progressBar.style.width = progress + '%';

            // Update Buttons
            btnPrev.style.visibility = currentStep === 1 ? 'hidden' : 'visible';
            
            if (currentStep === totalSteps) {
                btnNext.style.display = 'none';
                btnSubmit.style.display = 'flex';
            } else {
                btnNext.style.display = 'flex';
                btnSubmit.style.display = 'none';
            }
        }

        btnNext.addEventListener('click', () => {
            if (currentStep < totalSteps) {
                currentStep++;
                updateWizard();
            }
        });

        btnPrev.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateWizard();
            }
        });
    });
</script>

@endsection
