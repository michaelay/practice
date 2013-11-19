#ifndef __VISITOR_H__
#define __VISITOR_H__

#include <boost/shared_ptr.hpp>

class Node; 

class Visitor; 
typedef boost::shared_ptr<Visitor> VisitorPtr; 

class Visitor { 
public: 
  Visitor() {}; 

  // visit methods for different classes 
  void visit(Node*);
}; 

#endif 
