import 'bootstrap.native/dist/bootstrap-native-v4';
import hello from './lib/hello';

document.addEventListener('DOMContentLoaded', () => {
  console.log(hello('World!'));
});
