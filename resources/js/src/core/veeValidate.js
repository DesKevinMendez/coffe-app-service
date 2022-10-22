import { configure, defineRule } from 'vee-validate';
import AllRules from '@vee-validate/rules';
import { loadLocaleFromURL, localize } from '@vee-validate/i18n';
Object.keys(AllRules).forEach(rule => {
  defineRule(rule, AllRules[rule]);
});

loadLocaleFromURL(
  'https://unpkg.com/@vee-validate/i18n@4.1.0/dist/locale/es.json'
);

configure({
  generateMessage: localize('es'),
  validateOnBlur: true, // controls if `blur` events should trigger validation with `handleChange` handler
  validateOnChange: true, // controls if `change` events should trigger validation with `handleChange` handler
  validateOnInput: true, // controls if `input` events should trigger validation with `handleChange` handler
  validateOnModelUpdate: true,
});