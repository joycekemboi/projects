angular.module('project').value('settings',{
  HOST: window.location.protocol + '//'+ window.location.hostname + window.location.pathname,
  get ASSETS(){return this.HOST+'assets/'}
})