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
        {!! UVigoThemeWPApp::getThumbnailAndCaption('large') !!}
      </div>
    @endif
  </header>
  <div class="entry-section general-data">
    <p class="field">
      <span class="field__label">{{ __('Type', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_teacher_job_type') }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Department', 'uvigothemewp') }}: </span>
      <span class="field__item">{!! do_shortcode('[uvigo_departments post_id=' . get_the_ID() . ' ][/uvigo_departments]') !!}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Area', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_teacher_job_area') }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Dedication', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_teacher_job_dedication') }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Subjects', 'uvigothemewp') }}: </span>
      <span class="field__item">{!! do_shortcode('[uvigo_subjects template="clasificated" id_pdi=' . get_the_ID() . ' ][/uvigo_subjects]') !!}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Personal Web', 'uvigothemewp') }}: </span>
      <span class="field__item"><a href="{{ the_field('uvigo_teaching_contact_web') }}" target="_blank">{{ get_post_meta( get_the_ID(), 'uvigo_research_group_contact_url', true ) }}</a></span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Teaching experience', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_teacher_experience_teaching') }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Research experience', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_teacher_experience_research') }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Professional experience', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_teacher_experience_work') }}</span>
    </p>
  </div>
  <div class="entry-section contact-data">
    <h2>{{ __('Contact Data', 'uvigothemewp') }}</h2>
    <p class="field">
      <span class="field__label">{{ __('Office', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_tutorial_office') }}</span>
    </p>
    <p class="field">
        <span class="field__label">{{ __('Phone', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_contact_phone') }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Email', 'uvigothemewp') }}: </span>
      <span class="field__item"><a href="mailto:{{ the_field('uvigo_teaching_contact_email') }}" target="_blank">{{ get_post_meta( get_the_ID(), 'uvigo_research_group_contact_mail', true ) }}</a></span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Tutorials 1C', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_tutorial_1c') }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Tutorials 2C', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_tutorial_2c') }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Tutorials other periods', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ the_field('uvigo_teaching_tutorial_other') }}</span>
    </p>
  </div>

</article>
