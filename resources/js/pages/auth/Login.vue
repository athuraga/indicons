<template>
  <div class="login-page--container" :class="{ 'recruiter-bg': recruiterRole }">
    <div v-if="!$matchMedia.xl" class="login-page--logo">
      <router-link :to="{ name: 'index' }">
        <img src="/images/logo.svg" alt="">
      </router-link>
    </div>
    <div v-else class="desktop-login__left--container">
      <div>
        <img :src="role.img.top" alt="" class="desktop-login__left--img desktop-login__left-top--img">
      </div>
      <div class="flex-row space-between mt-2_5" :class="role.class.midImage">
        <div class="flex-column space-between h100">
          <img :src="role.img.midLeft" alt="" class="desktop-login__left--img desktop-login__left-mid-small--img">
          <router-link :to="{ name: 'index' }">
            <img src="/images/big-logo.png" class="desktop-login__left-mid-logo--img" alt="">
          </router-link>
        </div>
        <img :src="role.img.midRight" alt="" class="desktop-login__left--img desktop-login__left-mid-big--img ">
      </div>
      <div>
        <h2 class="desktop-login__left--h2 mt-1_5">
          {{ role.text }}
        </h2>
      </div>
    </div>

    <div class="login-form--container">
      <router-link v-if="$matchMedia.xl" :to="{ name: 'index' }" class="mx-auto mb-2_5">
        <img class="desktop-nav__logo" src="/images/logo-blue.svg" alt="">
      </router-link>

      <h1 class="login--h1">
        Who are you?
      </h1>
      <div class="login-role--container">
        <div>
          <input id="login-consultant" v-model="form.role" class="login-radio" type="radio" value="Consultant">
          <label class="login-radio--label" for="login-consultant" @click="chooseConsultant">Consultant</label>
        </div>
        <div>
          <input id="login-recruiter" v-model="form.role" class="login-radio" type="radio" value="Recruiter">
          <label class="login-radio--label" for="login-recruiter" @click="chooseRecruiter">Recruiter</label>
        </div>
      </div>

      <div v-if="!$matchMedia.xl" class="role--choose-effect" :class="{ 'role--consultant': consultantRole, 'role--recruiter': recruiterRole }" />
      <div v-else class="separator mt-1_5 mb-2">
        Sign In
      </div>

      <form @submit.prevent="login" @keydown="form.onKeydown($event)">
        <!-- Email -->
        <div class="login-input--container">
          <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="login-input" type="email" name="email" placeholder="Email" autocomplete="username" required>
          <has-error :form="form" field="email" />
        </div>

        <!-- Password -->
        <div class="login-input--container">
          <div class="right-tag__group ">
            <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="right-tag__input login--left-border" :type="passwordType" name="password" placeholder="Password" autocomplete="current-password" required>
            <div v-show="hidePassword" class="pointer right-tag" @click="togglePassword">
              <span class="iconify password__hide-icon" data-icon="carbon:view-off-filled" width="20" height="20" />
            </div>
            <div v-show="!hidePassword" class="pointer right-tag" @click="togglePassword">
              <span class="iconify password__hide-icon " data-icon="carbon:view-filled" width="20" height="20" />
            </div>
          </div>
          <has-error :form="form" field="password" />
        </div>

        <!-- Remember Me -->
        <div class="login-input--container">
          <label class="checkbox-container checkbox-container--post">Remember Me
            <input v-model="remember" name="remember" type="checkbox">
            <span class="checkbox-checkmark checkbox-checkmark-remember" />
          </label>
        </div>

        <div class="">
          <!-- Submit Button -->
          <v-button :loading="form.busy" class="login-submit--button" :class="{ 'is-recruiter': recruiterRole }">
            Sign In
          </v-button>
        </div>
      </form>
      <div class="login-extra">
        <p>
          Don't have an account?
          <router-link :to="{ name: 'register' }" class="login-link">
            <b>Sign Up</b>
          </router-link>
        </p>
        <p>
          <router-link :to="{ name: 'password.request' }" class="login-link">
            <b>Forgot Password?</b>
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
  name: 'LoginPage',
  layout: 'wide',
  middleware: 'guest',

  metaInfo () { return { title: 'Sign In' } },

  data: () => ({
    consultantRole: false,
    recruiterRole: false,
    hidePassword: true,
    passwordType: 'password',

    form: new Form({
      role: 'Consultant',
      email: '',
      password: ''
    }),
    remember: false
  }),

  computed: {
    ...mapGetters({
      snackbar: 'notification/snackbar'
    }),

    role () {
      if (this.form.role === 'Consultant') {
        return {
          img: {
            top: '/images/login-top-consultant.png',
            midLeft: '/images/login-mid-left-1-consultant.png',
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
    }
  },

  methods: {
    async login () {
      const isRecruiter = this.form.email.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@(?!.*(consultant)).*.ac.id.*$/)

      if (this.form.role === 'Recruiter' && !isRecruiter) {
        this.snackbar.open('You are likely not using a recruiter identity.')
        this.chooseConsultant()
        this.form.role = 'Consultant'
        return
      } else if (this.form.role === 'Consultant' && isRecruiter) {
        this.snackbar.open('You are likely using a recruiter identity. ')
        this.chooseRecruiter()
        this.form.role = 'Recruiter'
        return
      }

      this.form.post('/api/login')
        .then(({ data }) => {
          this.$store.dispatch('auth/saveToken', {
            token: data.token,
            remember: this.remember
          })
          this.$router.back()
        })
        .catch(e => {
          // console.log(e.response.data.message)
        })
    },

    chooseConsultant () {
      this.consultantRole = true
      this.recruiterRole = false
    },

    chooseRecruiter () {
      this.recruiterRole = true
      this.consultantRole = false
    },
    togglePassword () {
      this.hidePassword = !this.hidePassword
      this.passwordType = this.hidePassword ? 'password' : 'text'
    }
  }
}
</script>
