<template>
  <jet-authentication-card>
    <template #logo>
      <jet-authentication-card-logo />
    </template>

    <div class="mb-4 text-sm text-gray-600">
      This form for verifying your phone number ,could you verify the code we
      just send to you and enter on the section below,If you didn't receive the
      code, we will gladly send you another.
    </div>
    <div v-if="verificationLinkSent">
      <div class="mb-4 font-medium text-sm text-green-600">
        Verification code has been sent to your phone number
      </div>
      <form @submit.prevent="submit_code">
        <div class="mt-4 mb-4">
          <jet-label for="code" value="Code" />
          <jet-input
            id="code"
            type="text"
            class="mt-1 block w-full"
            v-model="code"
            required
          />
        </div>

        <jet-button
          :class="{ 'opacity-25': form_code.processing }"
          :disabled="form_code.processing"
        >
          Verify
        </jet-button>
      </form>
      <div v-if="verificationLinkInvalid" class="mb-4 font-medium text-sm text-red-600">
        Verification code Invalid
      </div>
      
    </div>
    <div v-if="verificationLinkNotSend">
      <div class="mb-4 font-medium text-sm text-green-600">
        Verification code not sent try again
      </div>
    </div>

    <form @submit.prevent="submit">
      <div class="mt-4 flex items-center justify-between">
        <jet-button
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          id="sendCode"
        >
          Send verification Code
        </jet-button>

        <inertia-link
          :href="route('logout')"
          method="post"
          as="button"
          class="underline text-sm text-gray-600 hover:text-gray-900"
          >Logout</inertia-link
        >
      </div>
    </form>
  </jet-authentication-card>
</template>

<script>
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";
import JetButton from "@/Jetstream/Button";

import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import firebase from "firebase/app";
require("firebase/auth");
export default {
  components: {
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
    JetInput,
    JetLabel,
  },

  props: {
    firebase_config: Object,
    status: String,
    sessionInfo: String,
  },

  data() {
    return {
      recapchaToken: "",
      code: "",
      form: this.$inertia.form({}),
      form_code: this.$inertia.form({}),
    };
  },

  methods: {
    submit() {
      this.form = this.$inertia.form({
        recapchaToken: this.recapchaToken,
      });
      this.form.post(this.route("phone.verify"));
    },
    submit_code() {
      this.form_code = this.$inertia.form({
        code: this.code,
        sessionInfo: this.sessionInfo,
      });

      this.form_code.post(this.route("phone.verify.code"));
    },
  },

  computed: {
    verificationLinkSent() {
      return this.status === "phone-code-sended";
    },
    verificationLinkInvalid() {
      return this.status === "phone-code-invalid";
    },
    verificationLinkNotSend() {
      return this.status === "phone-code-notsended";
    },
  },
  mounted() {
    const self = this;
    var firebaseConfig = this.firebase_config;
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier("sendCode", {
      size: "invisible",
      callback: function (recapchaToken) {
        self.recapchaToken = recapchaToken;
        self.submit();
      },
    });

    window.recaptchaVerifier.render().then(function (widgetId) {
      window.recaptchaWidgetId = widgetId;
    });
  },
};
</script>
