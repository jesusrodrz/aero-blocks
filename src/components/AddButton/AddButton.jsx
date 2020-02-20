import Icon from '../AddIcon.jsx';
import './style.scss';
const AddButton = props => {
  const classes = [props.className, 'add-button'].join(' ');
  return (
    <button {...props} className={classes}>
      {props.children ? props.children : <Icon />}
    </button>
  );
};
export default AddButton;
