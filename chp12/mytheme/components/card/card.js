(function (Drupal) {
  Drupal.behaviors.cardComponent = {
    attach(context) {
      context.querySelectorAll('.card').forEach((card) => {
        card.addEventListener('click', () => {
          card.classList.toggle('card--expanded');
        });
      });
    },
  };
})(Drupal);
