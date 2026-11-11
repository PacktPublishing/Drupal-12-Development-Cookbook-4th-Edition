(function (Drupal) {
  Drupal.behaviors.myThemeMain = {
    attach(context) {
      const elements = context.querySelectorAll('[data-animate]');
      elements.forEach((el) => {
        el.classList.add('is-visible');
      });
    },
  };
})(Drupal);
