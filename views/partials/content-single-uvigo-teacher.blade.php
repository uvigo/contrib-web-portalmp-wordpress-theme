<article @php(post_class())>
  <header>
    <h1 class="entry-title">{{ get_the_title() }}</h1>
    @if (has_excerpt())
      <div class="entry-excerpt">
        @php(the_excerpt())
      </div>
    @endif
    {{-- @include('partials/entry-meta') --}}
    {{-- @include('partials/entry-tax') --}}
    @if (has_post_thumbnail())
      <div class="entry-thumbnail">
        {!! App::getThumbnailAndCaption('large') !!}
      </div>
    @endif
  </header>
  <div class="entry-section general-data">
    <div class="field">
      <span class="field__label">{{ __('Type', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_teacher_job_type') }}</span>
    </div>
    <div class="field">
      <span class="field__label">{{ __('Department', 'uvigothemewp') }}: </span>
      <span class="field__item">{!! do_shortcode('[uvigo_departments post_id=' . get_the_ID() . ' ][/uvigo_departments]') !!}</span>
    </div>
    <div class="field">
      <span class="field__label">{{ __('Area', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_teacher_job_area') }}</span>
    </div>
    <div class="field">
      @php( $fieldDedication = get_field_object('uvigo_teaching_teacher_job_dedication') )
      @php( $fieldDedicationLabel = $fieldDedication['choices'][ $fieldDedication['value'] ] )
      <span class="field__label">{{ __('Dedication', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ $fieldDedicationLabel }}</span>
    </div>
    <div class="field">
      <span class="field__label">{{ __('Subjects', 'uvigothemewp') }}: </span>
      <span class="field__item">{!! do_shortcode('[uvigo_subjects template="clasificated" id_pdi=' . get_the_ID() . ' ][/uvigo_subjects]') !!}</span>
    </div>

    @php( $web = get_post_meta( get_the_ID(), 'uvigo_teaching_contact_web', true ) )
    @if( $web )
      <div class="field">
        <span class="field__label">{{ __('Personal Web', 'uvigothemewp') }}: </span>
        <span class="field__item"><a href="{{ the_field('uvigo_teaching_contact_web') }}" target="_blank">{{ $web }}</a></span>
      </div>
    @endif

    @php( $experience_teaching = get_post_meta( get_the_ID(), 'uvigo_teaching_teacher_experience_teaching', true ) )
    @if( $experience_teaching )
    <div class="field">
      <span class="field__label">{{ __('Teaching experience', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ $experience_teaching }}</span>
    </div>
    @endif

    @php( $experience_research = get_post_meta( get_the_ID(), 'uvigo_teaching_teacher_experience_research', true ) )
    @if( $experience_research )
    <div class="field">
      <span class="field__label">{{ __('Research experience', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ $experience_research }}</span>
    </div>
    @endif

    @php( $experience_work = get_post_meta( get_the_ID(), 'uvigo_teaching_teacher_experience_work', true ) )
    @if( $experience_work )
    <div class="field">
      <span class="field__label">{{ __('Professional experience', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ $experience_work }}</span>
    </div>
    @endif

  </div>
  <div class="entry-section contact-data">
    <h2>{{ __('Contact Data', 'uvigothemewp') }}</h2>
    <div class="field">
      <span class="field__label">{{ __('Office', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_tutorial_office') }}</span>
    </div>
    <div class="field">
        <span class="field__label">{{ __('Phone', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_contact_phone') }}</span>
    </div>
    @php( $fax = get_post_meta( get_the_ID(), 'uvigo_teaching_contact_fax', true ) )
    @if( $fax )
    <div class="field">
        <span class="field__label">{{ __('Fax', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_contact_fax') }}</span>
    </div>
    @endif
    <div class="field">
      <span class="field__label">{{ __('Email', 'uvigothemewp') }}: </span>
      <span class="field__item"><a href="mailto:{{ the_field('uvigo_teaching_contact_email') }}" target="_blank">{{ get_post_meta( get_the_ID(), 'uvigo_teaching_contact_email', true ) }}</a></span>
    </div>
    <div class="field">
      <span class="field__label">{{ __('Tutorials 1C', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_tutorial_1c') }}</span>
    </div>
    <div class="field">
      <span class="field__label">{{ __('Tutorials 2C', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_tutorial_2c') }}</span>
    </div>
    @php( $tutorial_other = get_post_meta( get_the_ID(), 'uvigo_teaching_tutorial_other', true ) )
    @if( $tutorial_other )
    <div class="field">
      <span class="field__label">{{ __('Tutorials other periods', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_tutorial_other') }}</span>
    </div>
    @endif
  </div>

</article>
