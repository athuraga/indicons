<template>
  <div class="register-page--container" :class="{ 'recruiter-bg': recruiterRole }">
    <div v-if="!$matchMedia.xl" class="login-page--logo">
      <router-link :to="{ name: 'index' }">
        <img src="/images/logo.svg" alt="">
      </router-link>
    </div>
    <div v-else class="desktop-login__left--container">
      <div>
        <img :src="role.img.top" alt="" class="desktop-register__left--img desktop-register__left-top--img">
      </div>
      <div class="flex-row space-between mt-1_5" :class="role.class.midImage">
        <div class="flex-column space-between h100">
          <img :src="role.img.midLeft" alt="" class="desktop-register__left--img desktop-register__left-mid-small--img">
        </div>
        <img :src="role.img.midRight" alt="" class="desktop-register__left--img desktop-register__left-mid-big--img ">
      </div>
      <div>
        <h2 class="desktop-login__left--h2 mt-1_5">
          {{ role.text }}
        </h2>
      </div>
    </div>

    <div class="resgiter-form--container">
      <router-link v-if="$matchMedia.xl" :to="{ name: 'index' }" class="mx-auto mb-1">
        <img class="desktop-nav__logo" src="/images/logo-blue.svg" alt="">
      </router-link>

      <h1 class="login--h1">
        You are?
      </h1>
      <div class="login-role--container">
        <div>
          <input id="login-consultant" v-model="form.role" class="login-radio" type="radio" value="Consultant" name="role">
          <label class="login-radio--label" for="login-consultant" @click="chooseConsultant">Consultant</label>
        </div>
        <div>
          <input id="login-recruiter" v-model="form.role" class="login-radio" type="radio" value="Recruiter" name="role">
          <label class="login-radio--label" for="login-recruiter" @click="chooseRecruiter">Recruiter</label>
        </div>
      </div>

      <div v-if="!$matchMedia.xl" class="role--choose-effect" :class="{ 'role--consultant': consultantRole, 'role--recruiter': recruiterRole }" />
      <div v-else class="separator mt-1_5 mb-2">
        Sign Up
      </div>

      <form @submit.prevent="register" @keydown="form.onKeydown($event)">
        <div class="form__input--group">
          <div class="form-group__container">
            <h4 class="form-group__input-name">
              First Name
            </h4>
            <div class="">
              <input v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-group__input-text" type="text" name="first_name" placeholder="e.g., John" required>
              <has-error :form="form" field="first_name" />
            </div>
          </div>

          <div class="form-group__container">
            <h4 class="form-group__input-name">
              Last Name
            </h4>
            <div class="">
              <input v-model="form.last_name" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-group__input-text" type="text" name="last_name" placeholder="e.g., Doe" required>
              <has-error :form="form" field="last_name" />
            </div>
          </div>
        </div>

        <div class="form-group__container">
          <h4 class="form-group__input-name">
            Email
          </h4>
          <div class="">
            <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-group__input-text" type="email" name="email" placeholder="e.g., johndoe@example.ac.id" autocomplete="username" required>
            <p v-if="form.role === 'Consultant'" class="form-group__input-info">
              You can use letters, numbers & periods
            </p>
            <p v-else class="form-group__input-info form-input__info--email">
              <span>You can use letters, numbers & periods.</span>
              <span>Academic email address only.</span>
            </p>
            <has-error :form="form" field="email" />
          </div>
        </div>

        <!-- Password -->
        <div class="form-group__container">
          <h4 class="form-group__input-name">
            Password
          </h4>
          <div class="">
            <div class="login-input--container">
              <div class="right-tag__group">
                <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="right-tag__input right-tag__input--form" :type="passwordType" name="password" placeholder="e.g., th!51sjh0nD03N0tj@n3D03" autocomplete="current-password" required>
                <div v-show="hidePassword" class="pointer right-tag" @click="togglePassword">
                  <span class="iconify password__hide-icon" data-icon="carbon:view-off-filled" width="20" height="20" />
                </div>
                <div v-show="!hidePassword" class="pointer right-tag" @click="togglePassword">
                  <span class="iconify password__hide-icon " data-icon="carbon:view-filled" width="20" height="20" />
                </div>
              </div>
              <has-error :form="form" field="password" />
            </div>
            <p class="form-group__input-info">
              Min. 8 characters with mix of letters, numbers & symbols
            </p>
            <has-error :form="form" field="password" />
          </div>
        </div>

        <div class="">
          <!-- Submit Button -->
          <v-button :loading="form.busy" class="login-submit--button" :class="{ 'is-recruiter': recruiterRole }">
            Sign Up
          </v-button>
        </div>
      </form>

      <div class="register-extra">
        <p>
          Already had an account?
          <router-link :to="{ name: 'login' }" class="login-link">
            <b>Sign In</b>
          </router-link>
        </p>
      </div>
      <div v-if="$matchMedia.xl" class="desktop-login__footer">
        PHive, All Rights Reserved. &copy; 2021 . | Created by FILKOM
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  name: 'RegisterPage',
  layout: 'wide',
  middleware: 'guest',

  metaInfo () { return { title: 'Sign Up' } },

  data: () => ({
    consultantRole: false,
    recruiterRole: false,
    hidePassword: true,
    passwordType: 'password',

    form: new Form({
      role: 'Consultant',
      first_name: '',
      last_name: '',
      email: '',
      password: ''
    }),
    mustVerifyEmail: false
  }),

  computed: {
    role () {
      if (this.form.role === 'Consultant') {
        return {
          img: {
            top: '/images/register-top-consultant.png',
            midLeft: '/images/register-mid-left-consultant.png',
            midRight: '/images/login-mid-right-consultant.png'
          },
          class: {
            midImage: ''
          },
          text: 'Expand Your Careers.'
        }
      }

      return {
        img: {
          top: '/images/login-top-recruiter.png',
          midLeft: '/images/login-mid-left-1-recruiter.png',
          midRight: '/images/login-mid-right-recruiter.png'
        },
        class: {
          midImage: 'row-reverse'
        },
        text: 'Project for Everyone'
      }
    },

    ...mapGetters({
      snackbar: 'notification/snackbar'
    })
  },

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Must verify email first.
      if (data.status) {
        this.mustVerifyEmail = true
        this.snackbar.open(data.status)
        this.$router.push({ name: 'verification.check', params: { email: this.form.email } })
      } else {
        // Log in the user.
        const { data: { token } } = await this.form.post('/api/login')

        // Save the token.
        this.$store.dispatch('auth/saveToken', { token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })

        // Redirect home.
        this.$router.push({ name: 'index' })
      }
    },
    chooseConsultant () {
      this.consultantRole = true
      this.recruiterRole = false
      this.form.role = 'Consultant'
    },
    chooseRecruiter () {
      this.recruiterRole = true
      this.consultantRole = false
      this.form.role = 'Recruiter'
    },
    togglePassword () {
      this.hidePassword = !this.hidePassword
      this.passwordType = this.hidePassword ? 'password' : 'text'
    }
  }
}
</script>
