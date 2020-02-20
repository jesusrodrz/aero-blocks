const Icon = props => {
  const classes = [props.icon, props.className, ''].join(' ');
  return <i className={classes}></i>;
};

export default Icon;
